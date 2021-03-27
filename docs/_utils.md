# Namespace `\app\core`

## `OutputError`

*To store output error in an associative array*

### Attributes
`public array `**`$content`**: An associative array store the errors

### Methods

`public `**`_constructor()`**

- Constructs an empty output error object

`public `**`hasError`**`(string $attr)`

- Returns true if the error has a value for the attribute `$attr`

`public `**`isEmpty()`**

- Returns true if the `$content` of error is empty

`public `**`addError`**`(string $attr, string $val)`

- Add `$val` as the value for the attribute `$attr` into the object
- If `$val` is empty string, or the error has a value for attributes `$attr`, the changes will be ignored
