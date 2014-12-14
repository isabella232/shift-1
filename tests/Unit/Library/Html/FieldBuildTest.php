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

    public function testGeneratingCustomDateField()
    {
        $field = \Field::custom('date', 'testField', '2016-01-01', ['id' => 'testField', 'class' => 'control-field']);
        $expected = '<input id="testField" class="control-field" name="testField" type="text" value="2016-01-01">';

        $this->assertSame($field, $expected);
    }

    public function testGeneratingCustomTimeField()
    {
        $field = \Field::custom('time', 'testField', '22:19', ['id' => 'testField', 'class' => 'control-field']);
        $expected = '<input id="testField" class="control-field" name="testField" type="text" value="22:19">';

        $this->assertSame($field, $expected);
    }

    public function testGeneratingCustomDateTimeField()
    {
        $field = \Field::custom('datetime', 'testField', '2016-01-01 22:19', ['id' => 'testField', 'class' => 'control-field']);
        $expected = '<input id="testField" class="control-field" name="testField" type="text" value="2016-01-01 22:19">';

        $this->assertSame($field, $expected);
    }

    public function testGeneratingCustomSelectBoxField()
    {
        $options = ['1' => 'One', '2' => 'Two', '3' => 'Three'];

        $field = \Field::custom('select', 'testField', "2", ['id' => 'testField', 'class' => 'control-field', $options]);

        $expected =  '<select id="testField" class="control-field" name="testField">';
        $expected .= '<option value="1">One</option>';
        $expected .= '<option value="2" selected="selected">Two</option>';
        $expected .= '<option value="3">Three</option>';
        $expected .= '</select>';

        $this->assertSame($field, $expected);
    }
}
