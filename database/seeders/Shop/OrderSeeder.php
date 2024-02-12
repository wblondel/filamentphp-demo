<?php

namespace Database\Seeders\Shop;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\User;
use Database\Seeders\BaseSeeder;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class OrderSeeder extends BaseSeeder
{
    public function run(): void
    {
        $user = User::first();

        $customerIds = Customer::select('id')->pluck('id');
        $productsIds = Product::select('id')->pluck('id');

        $firstIdOrder = 0;
        $firstIdPayment = 0;

        $amountPerStep = 1_000;
        $steps = $this->NB_ORDERS / $amountPerStep;

        $this->withProgressBar($steps, function () use ($amountPerStep, &$firstIdOrder, &$firstIdPayment, $customerIds, $productsIds) {
            $orders = Order::factory($amountPerStep)
                ->sequence(fn($sequence) => [
                    'shop_customer_id' => $customerIds->random(),
                    'number' => 'OR' . Str::padLeft($firstIdOrder + $sequence->index, 6, '0')
                ])
                ->has(Payment::factory(rand($this->NB_MIN_PAYMENTS_PER_ORDER, $this->NB_MAX_PAYMENTS_PER_ORDER))
                    ->sequence(function ($sequence) use (&$firstIdPayment) {
                        return [
                            'reference' => 'PAY' . Str::padLeft($firstIdPayment += 1, 6, '0')
                        ];
                    })
                )
                ->has(
                    OrderItem::factory()->count(rand($this->NB_MIN_ORDER_ITEMS_PER_ORDER, $this->NB_MAX_ORDER_ITEMS_PER_ORDER))
                        ->state(fn(array $attributes, Order $order) => [
                            'shop_product_id' => $productsIds->random()
                        ]),
                    'items'
                )
                ->create();

            $firstIdOrder += $amountPerStep;

            return $orders;
        }, $amountPerStep);

        foreach (Order::inRandomOrder()->take(rand(5, 8))->get() as $order) {
            Notification::make()
                ->title('New order')
                ->icon('heroicon-o-shopping-bag')
                ->body("{$order->customer->name} ordered {$order->items->count()} products.")
                ->actions([
                    Action::make('View')
                        ->url(OrderResource::getUrl('edit', ['record' => $order])),
                ])
                ->sendToDatabase($user);
        }
    }
}
