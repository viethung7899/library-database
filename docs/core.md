# Namespace `\app\core`

## `Requst`

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

- Returns the body of the incoming request as an assocative array

> **For example**: Suppose the incoming request destination is `http://example.com/edit/user?`**`id=1&name=John`**.
> This method will return `['id' => 1, 'name' => 'John']`

## `Response`

### Attributes

`public array `**`$content`**: An assocative array store the body of the response object

`public OutputError `**`$errors`**: An object to store the error of the object

### Methods

`public `**`_constructor()`**

- Constructs an empty response object

`public `**`ok()`**

- Returns errors if there is no error in the response

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

`public `**`getDatabase`**`(array $config)`

- Returns the database with specific configuration

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
