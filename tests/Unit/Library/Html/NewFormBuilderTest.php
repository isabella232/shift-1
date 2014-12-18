<?php namespace Tests\Unit\Library\Html;

use Mockery as m;
use Tests\UnitTestCase;
use Illuminate\Http\Request;
use Tectonic\Shift\Library\Html\NewFormBuilder as FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Routing\RouteCollection;


class NewFormBuilderTest extends UnitTestCase
{
    /**
     * Setup the test environment.
     */
    public function init()
    {
        $this->urlGenerator = new UrlGenerator( new RouteCollection, Request::create('/foo', 'GET') );
        $this->htmlBuilder = new HtmlBuilder( $this->urlGenerator );
        $this->formBuilder = new FormBuilder( $this->htmlBuilder, $this->urlGenerator, 123 );

        $validator = m::mock( 'Tectonic\Application\Validation\Validator' );

        $validator->shouldReceive('getRules')
            ->andReturn([
                'name' => 'required|alpha',
                'email' => 'required|email',
                'textarea' => 'required',
                'select' => 'required'
            ]);

        $this->formBuilder->validator = $validator;
        $this->formBuilder->convertRulesToParsley();
    }

    /**
     * Destroy the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    public function testOpenNewForm()
    {
        // Run basic formbuilder for get, for some reason any post, put etc with hidden fields gets parsed into parsley (no idea why or how)
        $form1 = $this->formBuilder->open([ 'method' => 'GET' ]);
        $this->assertEquals('<form method="GET" action="http://localhost/foo" accept-charset="UTF-8" data-parsley-validate="data-parsley-validate">', $form1);
    }

    public function testFormText()
    {
        $form1 = $this->formBuilder->input('text', 'name');

        $this->assertEquals('<input data-parsley-required="" data-parsley-required-message="The name field is required." data-parsley-pattern="/^[a-zа-яё]+$/i" data-parsley-pattern-message="The name may only contain letters." name="name" type="text">', $form1);
    }
}