<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\PascalCaseToSnakeCaseTransformer;

class PascalCaseToSnakeCaseTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PascalCaseToSnakeCaseTransformer::class);
    }

    function its_transform_converts_an_pascal_case_string_into_snake_case()
    {
        $this::transform('APascalCaseString')->shouldEqual('a_pascal_case_string');
    }
}
