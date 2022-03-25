<?php

namespace Database\Seeders;

use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Полифония',
                'name_en' => 'Polifoniya',
                'options' => [
                    [
                        'name' => '4',
                        'name_en' => '4',
                    ],
                    [
                        'name' => '3',
                        'name_en' => '3',
                    ],
                    [
                        'name' => '2',
                        'name_en' => '2',
                    ],
                ]
            ],

            [
                'name' => 'Вайфай',
                'name_en' => 'Wi-fi',
                'options' => [
                    [
                        'name' => 'есть',
                        'name_en' => 'yes',
                    ],
                    [
                        'name' => 'нет',
                        'name_en' => 'no',
                    ],

                ]
            ],

            [
                'name' => 'Полигоны',
                'name_en' => 'Poligons',
                'options' => [
                    [
                        'name' => 'много',
                        'name_en' => 'many',
                    ],
                    [
                        'name' => 'мало',
                        'name_en' => 'little',
                    ],

                ]
            ],
            [
                'name' => 'Кнопки',
                'name_en' => 'Button',
                'options' => [
                    [
                        'name' => 'квадратные',
                        'name_en' => 'four-square ',
                    ],
                    [
                        'name' => 'круглые',
                        'name_en' => 'round',
                    ],

                ]
            ],
        ];

        foreach ($data as $property) {
            $property['created_at'] = Carbon::now();
            $property['updated_at'] = Carbon::now();
            $options = $property['options'];
            unset($property['options']);
            $propertyId = DB::table('properties')->insertGetId($property);

            foreach ($options as $option) {
                $option['created_at'] = Carbon::now();
                $option['updated_at'] = Carbon::now();
                $option['property_id'] = $propertyId;
                DB::table('property_options')->insert($option);
            }
        }
    }
}
