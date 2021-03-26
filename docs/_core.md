# Namespace `\app\core`

## `Model`

`public static `**`getDatabase()`**

- Returns the database instance coneecting to the app

`public static `**`verifyInput`**`(array $input, array $inputRules)`

- Verifies the input before by cheking it against its rules
  - `$input`: an associative array storing input information, each elememt has the form of `$attribute => $value`
  - `$inputRules`: an associative array storing input rules, each element has the form of `$attribute => $rules`

## `View`

`public `**`__construct`**`(string $view, string $layout)`

- Constrtucts a view witth specific view template and layout

`public `**`setLayout`**`(string $layout)`

- Sets the layout for the view

`public `**`setView`**`(string $view)`

- Sets the template for the view

`public `**`setTitle`**`(string $title)`

- Sets the title for the view

`public `**`loadParams`**`(array $params)`

- Loads the data into the view
  - `$params`: An associative array storing data for the view, each element has the form of `$variableName => value`

`public `**`render()`**

- Renders the view to the website

## `Controller`

`public atatic `**`generateView`**`(string $view, string $title, string $layout)`

- Constructs a view instance with a specific view template, a title, and a layout

----

## `Request`

### Methods

`public static `**`getPath()`**

- Returns the path of incoming reequest
> **For example**: Suppose the request destination is `http://example.com`**`/edit/user`**`?id=1`. The path of this request is `/edit/user`

`public static `**`method()`**

- Returns the method of incoming request. It is either `GET` or `POST`

`public static `**`isGet()`**

- Returns true if incoming request has `GET` method

`public static `**`isPost()`**

- Returns true if incoming request has `POST` method

`public static `**`body()`**

- Returns the body of the incoming request as an associative array

> **For example**: Suppose the incoming request destination is `http://example.com/edit/user?`**`id=1&name=John`**.
> This method will return `['id' => 1, 'name' => 'John']`

## `Response`

### Attributes

`public array `**`$content`**: An associative array store the body of the response object

`public OutputError `**`$errors`**: An object to store the error of the object

### Methods

`public `**`_constructor()`**

- Constructs an empty response object

`public `**`ok()`**

- Returns true if there are no errors in the response

`public static `**`redirect(string $path)`**

- Redirects to another site

`public static `**`setStatusCode(int $code)`**

- Sets the HTTP status code

## `Router`

### Attributes

`private string `**`$rootPath`**: Parent destination of the incoming request

`private static array `**`$routes`**: A common array to store all the routes of incoming requests

### Methods

`public `**`get`**`(string $path, string $controllerCallback)`

- Invokes the controller callback method when user request a `GET` method to this router
  - `$childPath`: the destination path of the router
  - `$controllerCallback`: an array with 2 elements; the first element is the Controller class or its derived classes; the second is the name of static method that controller class

`public `**`get`**`(string $path, string $controllerCallback)`

- Simmlar to `get` method, but for incoming request with `POST` method to this router

`public static `**`resolve()`**

- Resolves th incoming requests by finding approriate callback methods. If the methid is not found, it will rerdirect to 404 page

## `Application` <- `Router`

### Methods

`public `**`connectDatabase`**`(array $config)`

- Connects the database with specific configuration

`public `**`getDatabase`**`()`

- Returns the database instance coneecting to the app

`public static `**`getApp()`**

- Returns the instance of the `Application` app after contruction

`public static `**`getRootDir()`**

- Returns the currents directory where the app is located

## `Database`

### Methods

`public `**`_constructor`**`(array $config)`

- Creates an database instance with a specific configuration

`public `**`prepare`**`(array $query)`

- Prepare the query and return the PDO statment object
