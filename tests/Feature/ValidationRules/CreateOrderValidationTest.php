<?php

namespace Tests\Feature\ValidationRules;

use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Class  LoginValidationTest
 * @group Auth
 */
class CreateOrderValidationTest extends TestCase
{
    /**
     * @test
     * @dataProvider validationProvider
     *
     * @param $request_data             | The request that you want to Post|Get by.
     * @param $form_input               | The Form Key Name.
     * @param $validation_error_message | The expected validation error message for the given form input.
     */
    public function it_returns_validation_error($request_data, $form_input, $validation_error_message)
    {
        $request_data = is_callable($request_data) ? $request_data() : $request_data;

        $this->json('POST','/api/orders',
         $request_data,)
            ->assertStatus(422)
            ->assertJson([
                $form_input => [
                    $validation_error_message,
                ],
            ]);
    }

    /**
     * Data provider method that contain keys names and the relative
     * validation message after looping on each key and get the error message
     *
     * @return array
     */
    public function validationProvider(): array
    {
        return [

            'Test [products] is [required]'          => [
                'request_data'             => [
                    'products' => [],
                ],
                'form_input'               => 'products',
                'validation_error_message' => 'The products field is required.',
            ],

            'Test [products.0.quantity] is [required]'          => [
                'request_data'             => [
                    'products'=>[
                        [
                            'quantity'=>''
                        ]
                    ],
                ],
                'form_input'               => 'products.0.quantity',
                'validation_error_message' => 'The products.0.quantity field is required.',
            ],
            'Test [products.0.product_id] is [required]'          => [
                'request_data'             => [
                    'products'=>[
                        [
                            'product_id'=>''
                        ]
                    ],
                ],
                'form_input'               => 'products.0.product_id',
                'validation_error_message' => 'The products.0.product_id field is required.',
            ],
            'Test [products..0.quantity] is [valid]'          => [
                'request_data'             => [
                    'products'=>[
                        [
                            'product_id'=>1,
                            'quantity'=>2001,
                        ]
                    ],
                ],
                'form_input'               => 'products',
                'validation_error_message' => 'The selected products.0.quantity is invalid.',
            ],

        ];
    }

}
