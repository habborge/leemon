<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $user = factory(App\User::class, 1)->create();
        // $products = factory(App\Product::class, 180)->create();
        // $products = App\Product::all();
        // $products->each(function(App\Product $product) use ($products) {
        //     $lots = factory(App\Lot::class,$product->id)
        //     ->times(1)
        //     ->create([
        //         'product_id' =>   $product->id,
        //     ]);
        //     $lots->each(function(App\Lot $lot) use ($lots) {
        //         $lotDetatils = factory(App\LotDetails::class, $lot->id)
        //         ->times(1)
        //         ->create([
        //             'lot_id' => $lot->id,
        //             'product_id' => $lot->product_id,
        //             'lot_code' => $lot->lot_code,
        //         ]);
                
        //     });
            
        // });

        // $lots = App\lot::all();
        // $lots->each(function(App\Lot $lot) use ($lots) {
        //     $stock = factory(App\Stock::class, $lot->id)
        //     ->times(1)
        //     ->create([
        //         'lot_id' => $lot->id,
        //         'warehouse_id' => 1,
        //         'product_id' => $lot->product_id,
        //     ]);
        // });  
        // $this->call(DptoSeeder::class);
        $this->call(CountrySeeder::class);
    }
}
