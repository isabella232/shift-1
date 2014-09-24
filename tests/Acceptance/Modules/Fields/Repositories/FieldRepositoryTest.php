<?php namespace Tests\Acceptance\Modules\Fields\Repositories;

use App;
use Doctrine\ORM\EntityManager;
use Mockery;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Fields\Repositories\DoctrineFieldRepository;

class FieldRepositoryTest extends AcceptanceTestCase
{
    /**
     * Data array complete with all required field to make a new CustomField
     *
     * @var array
     */
    protected $cleanData;

    /**
     * Setup method to run before each test
     */
    public function setUp()
    {
        parent::setUp();

        $this->cleanData = [
            'resource'     => 'user',
            'type'         => 'text',
            'field_title'  => 'Custom field title 1',
            'field_code'   => 'CFT',
            'group'        => 'eh',
            'label'        => '',
            'options'      => '',
            'validation'   => '',
            'settings'     => '',
            'required'     => true,
            'registration' => true,
            'order'        => 1
        ];

        $this->repository = new DoctrineFieldRepository(App::make(EntityManager::class));
    }

    /**
     * Test repository calls the correct methods on CREATE and READ operations.
     *
     * @test
     */
    public function testRepositoryPerformsCreateAndReadOperations()
    {
        $field = $this->create();

        $this->assertSame($field, $this->repository->getById($field->getId()));
    }

    /**
     * Test repository performs UPDATE by calling correct methods.
     *
     * @test
     */
    public function testRepositoryPerformsUpdateOperation()
    {
        $field = $this->create();

        $field->setFieldCode('something else');
        $field->setLabel('Dis label');

        $this->repository->update($field);

        // Assert
        $this->assertSame($field, $this->repository->getById($field->getId()));
    }

    /**
     * Test repository performs DELETE by calling correct methods
     *
     * @test
     */
    public function testRepositoryPerformsDeleteOperation()
    {
        $field = $this->create();

        $this->assertSame($field, $this->repository->getById($field->getId()));

        $this->repository->delete($field);

        $this->assertNull($this->repository->getById($field->getId()));
    }

    /**
     * @return mixed
     */
    protected function create(array $data = [])
    {
        $data = array_merge($this->cleanData, $data);
        $field = $this->repository->getNew($data);

        $this->repository->save($field);

        return $field;
    }


}
