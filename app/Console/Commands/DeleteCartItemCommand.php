<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\DeletedCart;
use Illuminate\Console\Command;

class DeleteCartItemCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-cart-item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedCart = Cart::where('created_at', '<=', now()->subDays(2))->delete();

        foreach($deletedCart as $cart) {
            DeletedCart::create([
                'item_description' => $cart->name,
                'stock_id' => $cart->stock_id,
                'user_id' => $cart->user_id,
            ]);

            $cart->delete();

            logger('Cart' . $cart->name . 'deleted!');
        }
    }
}
