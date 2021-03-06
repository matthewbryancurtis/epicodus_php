#Epicodus PHP Curriculum

Finished the Epicodus curriculum found at [learnhowtoprogram.com](https://www.learnhowtoprogram.com/php).

Working on the final project. It's going to be a [Cold Brew Journal](https://github.com/matthewbryancurtis/cold_brew).

## Contents

* [Takeaways](#takeaways)
* [Questions](#questions)

##Takeaways

### Meta-Markdown

I was trying to figure out the best way to add links in this Markdown README and I found that all I need to do is:

``` Markdown
* [Questions](#questions)

##Questions
```

And that gives me a nice little [link](#questions)!



### XAMPP Madness!

Using XAMPP and Sequel Pro. To get XAMPP to direct to working directory change `/Applications/XAMPP/xamppfiles/etc/httpd.conf`:

```
DocumentRoot "/Users/matthew/FULL_PATH/todo_list/web"
<Directory "/Users/matthew/FULL_PATH/todo_list/web">
```

where FULL_PATH is the path and

```
User USERNAME
```

where USERNAME is my username. Now I can restart XAMPP and go to `localhost` in a browser.

However, this only gets `index.php` working. To get all of the routing working as expected I created `.htaccess` in the `web` directory and added:

```
<IfModule mod_rewrite.c>
    Options -MultiViews

    RewriteEngine On
    #RewriteBase /path/to/app
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```
Via [Silex](http://silex.sensiolabs.org/doc/master/web_servers.html)

### PHP String Interpolation Pt 2

Function declarations don't seem to be able to be called during a string interpolation:

``` PHP
function getWord () {
  return "puppy";
}

$phrase = "I want a {getWord()}";

print $phrase;
// I want a {getWord()}
```

Anonymous functions store in a variable can be:

``` PHP
$getWord = function () {
  return "puppy";
}; // Don't forget that semicolon!

$phrase = "I want a {$getWord()}";

print $phrase;
// I want a puppy
```

And methods can be (using `$this` or a variable):

``` PHP
class Word {
  function getWord () {
    return "puppy";
  }
}

$instance = new Word();
$phrase = "I want a {$instance->getWord()}";

print $phrase;
// I want a puppy
```

Whereas a variable with a string doesn't need curly brackets, a method or function call does:

``` PHP
$word = "puppy";
$phrase = "I want a $word";

print $phrase;
// I want a puppy

$word = function () { return "puppy"; };
$phrase = "I want a $word()";

print $phrase;
// Error: Object of class Closure could not be converted to string
```

### PHP Doesn't Like Undefineds

``` PHP
// PHP

$arr = array();

print $arr["name"] ?: 0;

// Error Undefined Index: name
```

``` JavaScript
// JS

var obj = {};

console.log(obj["name"] ? obj["name"] : 0);

// 0
```

PHPUnit gets stopped dead in its tracks. Script in Atom returns an error for PHP but also `0`. The correct answer seems to be:

``` PHP
// PHP

$arr = array();

print isset($arr["name"]) ? $arr["name"] : 0;

// 0
```

Although this doesn't get to use the beauty of the `?:` operator. It is however more explicit.

### Explode Empty Delimiter

`explode != split`

``` JavaScript
//JS

"Hey".split("");
//["H", "e", "y"]
```

``` PHP
//PHP

explode("", "Hey");
//Error: empty delimiter

str_split("Hey");
//["H", "e", "y"]
```

### array_map and methods

This is pretty gnarly code, but it works. Simplified example:

``` PHP
class Capitalize {

  function capitalizeWord ($input) {
    return ucfirst($input);
  }

  function capitalizePhrase($input) {
    $input_array = explode(" ", $input);

    // This is the gnarly part:
    $output_array = array_map(array($this, "capitalizeWord"), $input_array);

    return implode(" ", $output_array);
  }

}
```

And this:

``` PHP
class Capitalize {

  function capitalizeWord ($input) {
    return ucfirst($input);
  }

  function capitalizePhrase($input) {
    $input_array = explode(" ", $input);

    // A little cleaner:
    $output_array = array_map("Capitalize::capitalizeWord", $input_array);

    return implode(" ", $output_array);
  }

}
```

And for S&Gs:

``` PHP
class Capitalize {

  function capitalizeWord ($input) {
    return ucfirst($input);
  }

  function capitalizePhrase($input) {
    return implode(" ", array_map("Capitalize::capitalizeWord", explode(" ", $input)));
  }

}
```

Makes me miss:

``` JavaScript
//JavaScript
function capitalizePhrase(input) {
  return input.split(" ").map(capitalizeWord).join(" ");
}
```

### Pre & Post Increment

They do different things!

``` PHP
$count = 5;
$count2 = count++;

print $count; // 6
print $count; // 5

$count = 5;
$count2 = ++count;

print $count; // 6
print $count; // 6
```

### PHP-Twig

Syntax highlighting in Atom with PHP-Twig. Also makes autoclose-html magically work.

### Closure Quirk Pt 2

As mentioned before, PHP doesn't use closures by default:

``` PHP
$number1 = 5;

function multiply ($number2) {
  return $number1 * $number2;
}

echo multiply(3);
// Error; $number1 is not in scope
```

Closures have to be explicitly declared:

``` PHP
$number1 = 5;

$multiply = function ($number2) use ($number1) {
  return $number1 * $number2;
}

echo multiply(3);
// 15
```

So far, I have only found references to closures with anonymous functions.

### Installing Composer

Found a lot of conflicting resources explaining how to install Composer. This was the simplest and seemed to work (assuming Homebrew is installed):

`brew install homebrew/php/composer`

### The Truth About "0"

In PHP:

``` PHP
if ("0") { print "Hello"; }
else { print "Goodbye"; }

// "Goodbye"
```

in JS:

``` JavaScript
if ("0") { console.log("Hello"); }
else { console.log("Goodbye"); }

// "Hello"
```

### Default Values

Setting up default values in PHP:

``` PHP
$numbers = array(1, 2, 3, false);

foreach ($numbers as $number) {
  echo $number || "undefined";
}
// "1111" type coercion?

foreach ($numbers as $number) {
  echo $number ?: "undefined";
}
// "123undefined" using PHP's ternary shorthand
```

JavaScript (without using default values):

``` JavaScript
let numbers = [1, 2, 3, false];

numbers.forEach(elem => console.log(elem || "undefined"));
// "123undefined"

numbers.forEach(elem => console.log(elem ? elem : "undefined"));
// "123undefined"
```

``` PHP
// PHP
print false || 2; // 1 - a coercion of true
print false ?: 2; // 2
var_dump(false || 2); // bool(true)
```

``` JavaScript
// JS
console.log(false || 2); // 2
console.log(false ? false : 2); // 2
```

In PHP the or (`||`) operator returns a boolean rather than a value like in JavaScript.

### PHP String Interpolation

Interesting PHP string interpolation:

``` PHP
$language = "PHP";
$comment = "$language is interesting!";

print $comment;
// "PHP is interesting!"
```

Whereas in ES6:

``` JavaScript
let language = "JavaScript",
    comment = `${language} is interesting!`;

console.log(comment);
// "JavaScript is interesting!"
```

In PHP `""` and `''` are different. So:

``` PHP
$language = "PHP";
$comment = '$language is interesting!'; // Note the single quotes

print $comment;
// "$language is interesting!"
```

Single quotes prevents accidental string interpolation.

### Closure or Scope Quirk

Not sure if this would be categorized as a difference of scope or of closure, but I was interested by this PHP code:

``` PHP
$number1 = 5;

function multiply ($number2) {
  return $number1 * $number2;
}

echo multiply(3);
// Error; $number1 is not in scope
```

Whereas in JavaScript:

``` JavaScript
var number1 = 5

function multiply (number2) {
  return number1 * number2;
}

console.log(multiply(3));
// 15
```

### Quick Environment

It's a lot easier to work with PHP than I thought it would be. A local host can be run with `php -S localhost:8000` or a shell can be opened with `php -a` to do quick PHP programming and working with forms is really easy by referencing PHP scripts with `form action="script.php"` from an HTML or PHP file.

##Questions

### Default Method Return Values

``` PHP
//PHP

$in1 = "dog";

$in1 = str_split($in1); // Splits to an array
sort($in1); // Sorts the array
$in1 = implode($in1);

print $in1;
// dgo

$in1 = "dog";

$in1 = str_split($in1);
$in1 = implode(sort($in1));

print $in1;
// Error implode(): argument must be an array

$in1 = "dog";

$in1 = str_split($in1);
$in1 = sort($in1);

print $in1;
// 1
```

Why does `str_split` have to be reassigned whereas `sort` does not?

``` JavaScript
// JS

var in1 = "dog";

console.log(in1.split("").sort().join(""));
// dgo
```
