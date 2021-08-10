##### New Content Type Frontend and Backend development Guide #####

# Backend Development

## Database fields

- Example database fields (Event)

    id
    user_id - foreign key to users table
    title - string
    image - foreign key to uploads table
    description - text
    .......

## Create Model, Migration and Controller

`php artisan make:model Event`

`php artisan make:migration create_events_table`

`php artisan make:controller EventController --resource`

* Example Migration
```php
    Schema::create('events', function (Blueprint $table) {
        $table->integer('id', true);
        $table->string('title');
        $table->string('description');
        $table->unsignedInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
        $table->timestamps();
        ........
    });
```

Or you can do it simply using one command
`php artisan make:model Event -mcr`

After creating migration, do migrate.
`php artisan migrate` Or `php artisan migrate --path=database/migrations/{migration file name}`

### Create Relations between Event and Category, Attribute, Company(User)

- Relation between Event and Company (Many to One)

In User.php
```php
    public function events()
    {
        return $this->hasMany(Event::class);
    }
```
`$user->events`

- Relation between Event and Attribute

Simply include attribute trait
```php
    use App\Traits\AttributeTrait;

    class Event extends Model
    {
        use AttributeTrait;
```
`$event->attributes`

- Relation between Event and Category (Many to Many)

* User - Shop is in One to One relation.
`$user->shop`
* Shop - Category is in Many to Many relation
`$shop->categories`
* Event - User is in Many to One relation
`$user->events`

So each event will have categories which user has


### Create Seeder for default Event's attributes

Attribute types: `checkbox`, `dropdown`, `plain_text`, `country`, `number`, `date`

- Exmaple default attributes

* Date - Date attribute
* Location - Plain text attribute
* Country - Coutry attribute (we already have this attibute)
* Price - number
* Event type - Dropdown (Online/Offline)
.....

## Define routes

- Seller dashboard routes

```php
Route::group(['prefix' => 'seller', 'middleware' => ['seller', 'verified', 'user']], function() {

    //Events
    Route::get('/events', 'EventController@seller_events')->name('seller.events');
    Route::get('/events/create', 'EventController@seller_event_create')->name('seller.events.create');
    Route::get('/events/{id}/edit', 'EventController@seller_event_edit')->name('seller.events.edit');
});

Route::group(['middleware' => ['auth']], function() {

    //Events
    Route::post('/events/store/', 'EventController@store')->name('events.store');
    Route::post('/events/update/{id}', 'EventController@update')->name('events.update');
    Route::get('/events/destroy/{id}', 'EventController@destroy')->name('events.destroy');
});
```

- Events in Home page
```php
    Search by Query
    Route::get('/all_events', 'EventController@all_events')->name('events');

    Event Detail
    Route::get('/event/{id}', 'EventController@event')->name('event.visit');
    
    Search by Category
    Route::get('/events/category/{category_slug}', 'EventController@listingEventsByCategory')->name('events.category');
```

* Implement search/filter logic for new content type

```php
    public function all_events(Request $request, $category_id = null) {

        Filter logic reference controller
        ``` CompanyController@index ```

        ......

        return view('frontend.event_listing', compact('events', 'attributes', 'category_id', 'filters', 'title'));
    }

    public function listingEventsByCategory(Request $request, $category_slug) {
        $category = Category::where('slug', $category_slug)->first();
        if ($category != null) {
            return $this->all_events($request, $category->id);
        }
        abort(404);
    }
```

- Admin routes
```php
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
        // Events
        Route::resource('events', 'EventController');
        Route::get('/events/destroy/{id}', 'EventController@destroy')->name('events.destroy');
```



# Frontend Development


## Events in Seller Dashboard

### Navigation

* Add `Events` menu in user_side_nav.blade.php

### Folder Structure: All blade files need to be located in frontend/user/seller/events

- index.blade.php: route - seller.events

    Card design reference
    ``` https://htmlstream.com/front/snippets/directory-grid.html#component-3 ```

    Page design reference
    ``` http://localhost:8000/seller/digitalproducts ```

- create.blade.php: route - seller.events.create

    ``` https://dev.b2bwood.com/seller/digitalproducts/upload ```

- edit.blade.php: route - seller.events.edit

    ``` http://localhost:8000/seller/digitalproducts/{id}/edit?lang=en ```


## Event in Home page

- detail.blade.php(/frontend/event): route - event.visit

    ``` http://localhost:8000/shop/{slug} ```
    
- event_listing.blade.php(/frontend): route - events

    Card design reference
    ``` https://htmlstream.com/front/snippets/directory-grid.html#component-3 ```

    Page design reference
    ``` http://localhost:8000/sellers ```


## Events in Admin panel

### Navitation

* Add `Events` menu in admin_sidenav.blade.php

- Sub menu items
    `All Events`
    `Attributes`

### Folder Structure: All blade files need to be located in backend/events

- index.blade.php
    ``` http://127.0.0.1:8000/admin/sellers ```

- edit.blade.php
    ``` http://127.0.0.1:8000/admin/sellers/{id}/edit ```

- create.blade.php
    ``` http://127.0.0.1:8000/admin/sellers/create ```




# Example Cypress test


``` cypress/integration/document-gallery-crud.spec.js ```




# Example Seeder

``` database/seeders/SellersTableSeeder.php ```
