# Laravel Project Docs

## This was installed using Docker:

### To create a new project with Docker:

`curl -s "https://laravel.build/example-app" | bash`

### After its been created:

```cd example-app
./vendor/bin/sail up
```

Once that's done and you docker containers are running then:

`./vendor/bin/sail artisan migrate`

Seed docs: https://laravel.com/docs/11.x#sail-on-macos

If you migration fails due, it may be due to environment variable issues

### You may need to change the following:

```DB_HOST=0.0.0.0
DB_PASSWORD=password
```

Create Laravel Project:
`composer create-project laravel/laravel:^11.0 example-app`

Run the app:

```cd example-app
php artisan serve
```

For reference go to laravel-api repo on GitHub or on local machine
Also look at this course for reference : https://www.youtube.com/watch?v=YGqCZjdgJJk&t=319s&ab_channel=EnvatoTuts%2B

To run development server:
`php artisan serve`

If no api.php file found in the route folder:
`php artisan install:api`

## Creating database:

### First create new model:

-   [ ] To add new model:
-   [ ] php artisan make:model Invoice --all (where Invoice is the name of the model you want to add)
-   [ ] Then go to Models folder and add relationship in the model you just created

### Then add new table:

-   [ ] Go to database/migrations and add the table columns
-   [ ] Then go to database/factories and add the actual data that will populate the tables (if you need data)
-   [ ] Then go to database/seeders and in the relevant seeder you can add the specific number of data that you want under the specific seeder. Seeders that depend on another seeder (in this case Invoice /Movies depends on Customers/Director as one can’t be present without the other) you can create in just the Parent seeder (Customer/Director)
-   [ ] Then add the relevant seeder in the database/seeders/DatabaseSeeder.php

### From here you can run the migration:

`php artisan migrate:fresh --seed`
Or just
`php artisan migrate`

Laravel gives you resources to transform your response to an Eloquent json model. This will allow you to manipulate your returned data in a readable JSON way and also filter the data you get back accordingly by omitting what you don’t need.
You can make your resource by (where CustomerResource is the name of your resource):
`php artisan make:resource CustomerResource `

If you will version this then you will instead say:

`php artisan make:resource V1/CustomerResource`

## To make a new request (POST):

First note that Laravel 11 already creates the StoreRequest for you and you just need to place it into the correct folder (V1 if you want to version it then change the namespace to include the correct folder)

-   [ ] `php artisan make:request V1/StoreCustomerRequest` (if versioned, if not versioned then its php artisan make:request StoreCustomerRequest)
-   [ ] Then you need to go to your model (`Models/Customer.php`) and add all the items that you want to be fillable inside a fillable array
-   [ ] And go to your controller (`Controllers/Api/V1`), and inside the store method you want to add a return so that it returns what you need according to your resource
-   [ ] Inside your requests (`Requests/V1/StoreCustomerRequests`) you want to either change authorise to be true if you want only authorised users to do a specific action or keep it as false.
-   [ ] Then under the rules (in `Requests/V1/StoreCustomerRequests`) you want to specify your validation rules

### To make PUT or PATCH request:

PUT- will update all the items in an object
PATCH- will update only the ones you provide it, for example if you provide ‘name: John’, only it will be in the following object will be updated
`{name: Jake, surname: Riddle, phone: 1234} `

Same as above, Laravel 11 does this for you, you just need to place it into the correct version folder. But if you need a new one:

-   [ ] php artisan make:request V1/UpdateCustomerRequest (if versioned, if not versioned then its php artisan make:request UpdateCustomerRequest)
-   [ ] Similar to above simply just copy the rules that you have in the Store request and make minor modifications. You need to add the ‘sometimes’ validation rule then also check whether the request is a patch PUT or a PATCH. If its a put it won’t need the ‘sometimes’ validation rule since it will update everything
-   [ ] Make sure to check whether everything we have that is transformed into camel case is present or not or you will get an error

### To make Bulk insert (store many things at once):

-   [ ] You need to add your on bulkStore method in your controller. Consider bulkStore in the Invoice Controller
-   [ ] Add your own route inside ‘`routes/api.php`’, use a post (remember apiRoutes don’t have this new route method bulkStore defined in it) method for it
-   [ ] Specify where to route that request ie uses => ‘`InvoicesController@bulkStore`’
-   [ ] Then create your own versioned or un-versioned Store request: ‘`Requests/V1/BulkStoreInvoiceRequest`’
-   [ ] And ensure that your rules meet the correct data structure. In this case we are validating an array of objects
-   [ ] Then inside our prepareForValidation method inside the ‘`Requests/V1/BulkStoreInvoiceRequest`’ class we want to ensure that the camelCase keys are all accounted for and switched out to the relevant proper table names
-   [ ] Then inside our bulkStore method in our ‘`Controllers/Api/V1/InvoiceController`’ we want to ensure that whatever data we want to store don’t have any camelCase keys for tables inside the arrays. So we remove the arrays that may have data like that and then change it into an array and insert it into the Invoice table

### Authentication - To protect routes with Sanctum:

Sanctum is a token authentication scheme for APIs and SPAs

-   [ ] Create users and assign tokens to them, to do this in code create an endpoint and add them (see: routes/web.php Route::get(‘/setup’) method)
-   [ ] Essentially we are creating and endpoint that creates users and sets tokens to them
-   [ ] Then go to ‘routes/api.php’ and ensure that any of our routes are protected by adding 'middleware' => 'auth:sanctum’. Therefore the sanctum middleware will ensure that all our api routes are protected and can only be accessed by authorised users
-   [ ] Found an issue with the createToken method. To fix issue use the following: https://stackoverflow.com/questions/66785299/call-to-undefined-method-app-models-usercreatetokenIn summary import HasApiTokens from use Laravel\Sanctum\HasApiTokens; or use Laravel\Passport\HasApiTokens;
-   [ ] Then take your api keys and use them for authentication and authorisation
        API Keys:

```ts
{
"admin":"1|8BtaBp1zoO30MecTgQbC8jtexCq4iYR8pVwNFzIi28f9e2b9",
"update":"2|gzEOtE9hxwCjAhtLyuFuMxBWeLcwNSXrWTmSyh8Qbcd2c735",
"basic":"3|7zNqgTufTBmmFHLmIxDo853uD5EKhtWGpOu1pZaZ5ab4afbd"
}
```

-   [ ] From here try to access the customers by making a GET request to http://localhost:8000/api/v1/customers
-   [ ] You should then be redirected to login when trying to go to/access any of your api routes but it won’t be able to find login (since you have not created a login route, this is how you know it works), so you need to go to postman and use the above keys and add them to your authorisation headers in order to access any of your api routes
-   [ ] Go to postman, Click your authorisation tab, add change the type of your token to a ‘Bearer’ token. Then paste it inside the token input. Make the request again and you should get the customers data

### To add authorisation to your requests after getting api keys:

-   [ ] Open your `Requests/V1/StoreCustomerRequest` file
-   [ ] Under ‘authorize’ check if you have a user
-   [ ] If you do check if the user’s token can ‘create’ with the `tokenCan(‘create’)` method
-   [ ] For updating it should be tokenCan(‘update’) likewise for deleting as long as you have those methods defined
-   [ ] If you want to go even further to have only certain people create certain things you can allow your tokens to be more specific like `tokenCan(‘customer:update’)` or `tokenCan(‘invoice:create’)`
-   [ ] The above basic token has all the abilities as we had not defined any specific ability for it. This is a default behaviour. Make sure to assign abilities to all tokens and protect your routes against the mutable ones

Laravel Community:
https://laravel.io
