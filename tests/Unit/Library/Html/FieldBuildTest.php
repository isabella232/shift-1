<?php namespace Tests\Unit\Library\Html;

use Tests\UnitTestCase;

class FieldTest extends UnitTestCase
{
    public function testGeneratingCustomTextField()
    {
        $field = \Field::custom('text', 'testField', 'Test value', ['id' => 'testField', 'class' => 'control-field']);
        $expected = '<input id="testField" class="control-field" name="testField" type="text" value="Test value">';

        $this->assertSame($field, $expected);
    }

    public function testGeneratingCustomTextareaField()
    {
        $field = \Field::custom('textarea', 'testField', 'Test value', ['id' => 'testField', 'class' => 'control-field']);
        $expected = '<textarea id="testField" class="control-field" name="testField" cols="50" rows="10">Test value</textarea>';

        $this->assertSame($field, $expected);
    }

    public function testGeneratingCustomUncheckedCheckboxField()
    {
        $field = \Field::custom('checkbox', 'testField', '1', ['id' => 'testField', 'class' => 'control-field']);
        $expected = '<input id="testField" class="control-field" name="testField" type="checkbox" value="1">';

        $this->assertSame($field, $expected);
    }

    public function testGeneratingCustomCheckedCheckboxField()
    {
        $field = \Field::custom('checkbox', 'testField', '1', ['checked' => true, 'id' => 'testField', 'class' => 'control-field']);
        $expected = '<input checked="checked" id="testField" class="control-field" name="testField" type="checkbox" value="1">';

        $this->assertSame($field, $expected);
    }
}
