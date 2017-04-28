ArrayTransformer

This is a simple package that lets you build up a series of array
transformations so that you can apply them to several arrays more easily.

Start by creating an instance of the ArrayTransformer class:

    use MattyG\ArrayTransformer\ArrayTransformer;
    $t = new ArrayTransformer();

Now add some transformations:

    $t->values()
        ->diff(array("a", "c"));

Now apply the transformations to an array:

    $input = array("x" => "a", "y" => "b", "z" => "c");
    $output = $t->apply($input);

The $output variable should be as follows:

    ["b"]

This software is released into the public domain without any warranty.
