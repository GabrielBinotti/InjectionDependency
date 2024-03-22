# Example to use Injection of Dependency in PHP

This example is simple where I use some classes for representation.

## Injection of Dependency

This is a concept in POO. It's a design patter aimed at reducing the coupling between different parts of a software
system.

In resume, it involves providing a class with the necessary dependencies from outside the class itself,
rather than the class creating these dependencies on it own. 

So it's passed as a parameter of a method a class that holds the intelligence to execute the required action,
and to ensure that the passed class meet the standards and has the necessary methods, we use an interface to 
establish the contract.

Look example above.

## Person.php
```php
class Person
{
    private $data = [];


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

}
```

Now I need a method to return the data in json format. I could make:
```php
class Person
{
    private $data = [];


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function export()
    {
        return json_encode($this->data);
    }

}
```
This way, the method becomes entirely the responsibility of the class, and it's not possible to use
it in another class. I could make.

## JsonExporter.php

```php
class JsonExporter
{
    public function export(array $data)
    {
        return json_encode($data);
    }
}
```

## Person.php
```php
class Person
{
    private $data = [];


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function export()
    {
        $objJson = new JsonExporter;
        return $objJson->export($this->data);
    }

}
```

This way we have the same problem, where if we need a new format the export the data. It would be necessary to create a new method.

Now using injection of dependency.

## JsonExporter.php

```php
class JsonExporter
{
    public function export(array $data)
    {
        return json_encode($data);
    }
}
```

## Person.php
```php
class Person
{
    private $data = [];


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function export ($objExporter)
    {
        return $objExporter->export($this->data);
    }

}
```

But we have a problem, this way we do not have the guarantee that the class JsonExporter has the method export.
So we use interface.

## InterfaceExporter.php
```php
interface InterfaceExporter
{
    public function export(array $data);
}
```

## JsonExporter.php
```php
class JsonExporter implements InterfaceExporter
{
    public function export(array $data)
    {
        return json_encode($data);
    }
}
```

## Person.php
```php
class Person
{
    private $data = [];


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function export (InterfaceExporter $objExporter)
    {
        return $objExporter->export($this->data);
    }

}
```

Now we can use.

## index.php
```php

$person = new Person;

$person->name   = "Gabriel Binotti";
$person->age    = 31;
$person->email  = "gabrielbinotti.dev@gmail.com";

$result = $person->export(new JsonExporter);

print_r($result);
```

If you need to create a new return format, you can create a new class implementing the interface <strong>InterfaceExporter</strong>