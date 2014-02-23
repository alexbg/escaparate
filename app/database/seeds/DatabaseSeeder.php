<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		//Eloquent::unguard();

		$this->call('UserTableSeeder'); 
                
                $this->command->info('User table seeded!');
                
                $this->call('BrandTableSeeder');
                
                $this->command->info('Brand table seeded!');
                
                $this->call('PhoneTableSeeder');
                
                $this->command->info('Phone table seeded!');
                
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                
	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        $password = Hash::make('123123');
        DB::table('users')->delete();

        User::create(array(
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => $password,
            'date' => '12/12/1990',
            'language' => 'es')
        );
        
        User::create(array(
            'email' => 'prueba@gmail.com',
            'username' => 'prueba',
            'password' => $password,
            'date' => '12/12/1990',
            'language' => 'es')
        );
    }

}

class brandTableSeeder extends Seeder {

    public function run()
    {
        
        DB::table('brands')->delete();

        $brand = Brand::create(array(
            'name' => 'Marca1',
            'id_user' => '1',
            )
        );

        Brand::create(array(
            'name' => 'Marca2',
            'id_user' => '1',
            )
        );
        
        Brand::create(array(
            'name' => 'Marca3',
            'id_user' => '1',
            )
        );   
    }
}


class PhoneTableSeeder extends Seeder {

    public function run()
    {
        //$password = Hash::make('prueba123');
        DB::table('phones')->delete();

        
        // MARCA 1
        Phone::create(array(
            'name' => 'Movil marca 1',
            'id_brand' => '1',
            'id_user' => '1',
            'image' => 'http://cdn2.ubergizmo.com/wp-content/uploads/2013/10/Xiaomi-Mi3.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60.89',
            'discount' => 3
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 2 marca 1',
            'id_brand' => '1',
            'id_user' => '1',
            'image' => 'http://images.beyazgazete.com/haber/2013/12/9/Xiaomi-Mi3.png',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 20
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 3 marca 1',
            'id_brand' => '1',
            'id_user' => '1',
            'image' => 'http://i1.ytimg.com/vi/6DLW69w36Hs/maxresdefault.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 15
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 4 marca 1',
            'id_brand' => '1',
            'id_user' => '1',
            'image' => 'http://i-cdn.phonearena.com/images/articles/97074-image/Lenovo-Vibe-Z-K910.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 5
            )
        );
        
        // MARCA 2
        Phone::create(array(
            'name' => 'Movil marca 2',
            'id_brand' => '2',
            'id_user' => '1',
            'image' => 'http://i-cdn.phonearena.com/images/articles/81223-image/Xiaomi-Mi-3-big.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 40
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 2 marca 2',
            'id_brand' => '2',
            'id_user' => '1',
            'image' => 'http://static.knowyourmobile.com/sites/knowyourmobilecom/files/xiaomi-mi2s.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 20
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 3 marca 2',
            'id_brand' => '2',
            'id_user' => '1',
            'image' => 'http://i-cdn.phonearena.com/images/articles/109692-image/Xiaomi-Hongmi-1S.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 10,
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 4 marca 2',
            'id_brand' => '2',
            'id_user' => '1',
            'image' => 'http://i-cdn.phonearena.com/images/articles/97074-image/Lenovo-Vibe-Z-K910.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 60,
            )
        );
        
        //MARCA 3
        
        Phone::create(array(
            'name' => 'Movil marca 3',
            'id_brand' => '3',
            'id_user' => '1',
            'image' => 'http://www.blogcdn.com/www.engadget.com/media/2012/12/oppo-find-5-vs.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 30
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 2 marca 3',
            'id_brand' => '3',
            'id_user' => '1',
            'image' => 'http://www.geek.com/wp-content/uploads/2012/12/Oppo-Find-51.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 18
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 3 marca 3',
            'id_brand' => '3',
            'id_user' => '1',
            'image' => 'http://en.oppo.com/assets/media/products/find5/affection.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 20
            )
        );
        
        Phone::create(array(
            'name' => 'Movil 4 marca 3',
            'id_brand' => '3',
            'id_user' => '1',
            'image' => 'http://meizumxon.com/news/user/files/1a.jpg',
            'so' => 'android',
            'cpu' => 'cualquiera',
            'ram' => '6',
            'camera' => '5',
            'description' => 'Esto es la descripcion',
            'price' => '60',
            'discount' => 50
            )
        );
    }
}