<?php

$languages = [
	"clojure" => "Clojure",
	"coffeescript" => "CoffeeScript",
	"commonlisp" => "Common Lisp",
	"erlang" => "Erlang",
	"php" => "PHP",
	"htmlmixed" => "HTML",
	"dart" => "Dart",
	"css" => "CSS",
	"javascript" => "JavaScript",
	"django" => "Django",
	"python" => "Python",
	"go" => "Go",
	"julia" => "Julia",
	"ruby" => "Ruby",
	"r" => "R",
	"swift" => "Swift",
	"vue" => "Vue",
	"yaml" => "YAML",
	"lua" => "Lua",
	"markdown" => "Markdown",
	"sql" => "SQL",
	"shell" => "Shell",
	"xml" => "XML",
	"jsx" => "JSX",
	"nginx" => "Nginx",
	"pascal" => "Pascal",
	"pug" => "Pug",
];

ksort($languages);
$languages = array_unique($languages);