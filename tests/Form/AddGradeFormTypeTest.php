<?php

namespace App\Tests\Form;

use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\Test;
use App\Form\AddGradeFormType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class AddGradeFormTypeTest extends TypeTestCase
{
    public function testSubmitValidDataSimple()
    {
        $formData = [
            'grade' => 4.5,
        ];
        $model = new Grade();
        $form = $this->factory->create(AddGradeFormType::class, $model);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'The form is not synchronized');
    }

    public function testSubmitValidData()
    {
        $formData = [
            'grade' => 4.5,
            'student' => $this->createMock(Student::class),
            'test' => $this->createMock(Test::class),
        ];
        $model = new Grade();
        $form = $this->factory->create(AddGradeFormType::class, $model);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'The form is not synchronized');
        $this->assertEquals($model->getGrade(), $formData['grade'], 'The grade is not the same');

        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children, 'The form does not have the key ' . $key);
        }
    }

    public function testSubmitIncorrectGrade()
    {
        $formData = [
            'grade' => 10,
            'student' => $this->createMock(Student::class),
            'test' => $this->createMock(Test::class),
        ];
        $model = new Grade();
        $form = $this->factory->create(AddGradeFormType::class, $model);

        $form->submit($formData);

        $errors = $form->getErrors(true, true);
        $this->assertTrue($form->isSynchronized(), 'The form is not synchronized');
        $this->assertEquals('Grade must be between 1 and 6', $errors->current()->getMessage(), 'The error message is not the expected one');
    }

    protected function getExtensions()
    {
        return [new ValidatorExtension(Validation::createValidator())];
    }
}