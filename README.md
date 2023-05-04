# Foodics Burger System Task

# Requirements
## Main Models ( Product , Ingredient , Order )
## Main Endpoint ( Create Order) 
## Main Events ( Notify Merchant when an ingredient stock reaches 50% or less ) 


# Install 
````
git clone https://github.com/agtaweel/foodics-burger-system.git
cd foodics-burger-system
composer install
cp .env.example .env
cp .env.example .env.testing
````
> **Note**
> make sure to update .env & .env.testing with your local variables 
````
php artisan migrate --seed
php artisan serv --port=8000
````

# Postman Collection 
## Products
### GET 
[/api/products](#get-api-products)

## Orders
### POST 
[/api/orders](#post-api-orders)


### GET /api/products
Get paginated and filtered products list from the system
**Request**
````
{
    "id":1, //product id
    "name":"Beef", // product name
    "price_from":0, // min price
    "price_to":100, // max price
    "in_ingredients":[
        "beef",
        "chicken",
        "cheese",
        "onion"
    ] // ingredients name that must exists in the product
}
````

**Response**
````
{
    "data": [
        {
            "id": 1,
            "name": "Chicken Burger",
            "price": 45.97,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 2,
                    "name": "cheese",
                    "stock": 5000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 55,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 3,
                    "name": "onion",
                    "stock": 1000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 55,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 2,
            "name": "Beef Burger",
            "price": 32.91,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 2,
                    "name": "cheese",
                    "stock": 5000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 50,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 3,
                    "name": "onion",
                    "stock": 1000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 50,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 3,
            "name": "Beef Burger",
            "price": 52.88,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 1,
                    "name": "beef",
                    "stock": 20000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 24,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 3,
                    "name": "onion",
                    "stock": 1000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 24,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 4,
            "name": "Chicken Burger",
            "price": 59.03,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 1,
                    "name": "beef",
                    "stock": 20000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 17,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 2,
                    "name": "cheese",
                    "stock": 5000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 17,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 3,
                    "name": "onion",
                    "stock": 1000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 17,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 5,
            "name": "Chicken Burger",
            "price": 55.57,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 1,
                    "name": "beef",
                    "stock": 20000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 77,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 2,
                    "name": "cheese",
                    "stock": 5000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 77,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 6,
            "name": "Beef Burger",
            "price": 39.37,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 1,
                    "name": "beef",
                    "stock": 20000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 92,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 2,
                    "name": "cheese",
                    "stock": 5000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 92,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 7,
            "name": "Chicken Burger",
            "price": 43.92,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 2,
                    "name": "cheese",
                    "stock": 5000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 22,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 8,
            "name": "Beef Burger",
            "price": 82.64,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 1,
                    "name": "beef",
                    "stock": 20000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 46,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 9,
            "name": "Chicken Burger",
            "price": 64.04,
            "order_price": null,
            "quantity": null,
            "created": 1683196735,
            "updated": 1683196735,
            "ingredients": [
                {
                    "id": 1,
                    "name": "beef",
                    "stock": 20000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 80,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 2,
                    "name": "cheese",
                    "stock": 5000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 80,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 3,
                    "name": "onion",
                    "stock": 1000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 80,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        },
        {
            "id": 10,
            "name": "Chicken Burger",
            "price": 33.62,
            "order_price": null,
            "quantity": null,
            "created": 1683196736,
            "updated": 1683196736,
            "ingredients": [
                {
                    "id": 1,
                    "name": "beef",
                    "stock": 20000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 33,
                    "created": 1683196735,
                    "updated": 1683196735
                },
                {
                    "id": 3,
                    "name": "onion",
                    "stock": 1000,
                    "percentage": 100,
                    "unit": "g",
                    "weight": 33,
                    "created": 1683196735,
                    "updated": 1683196735
                }
            ]
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/products?page=1",
        "last": "http://127.0.0.1:8000/api/products?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/products?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/products",
        "per_page": 20,
        "to": 10,
        "total": 10
    }
}
````




### POST /api/orders
Create new order

**Request**
````
{
    "products": [
        {
            "product_id": 2, // product id
            "quantity": 1 // quntity
        }
    ]
}
````
