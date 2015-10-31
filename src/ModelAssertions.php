<?php namespace Viewpoint\LaravelTestHelpers;

trait ModelAssertions {

    public function assertIsAModel() {
        $class = $this->getClassUnderTest();
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Model', new $class() );
    }

    public function assertHasScope( $scope ) {
        $class = $this->getClassUnderTest();
        $this->assertTrue( method_exists($class, 'scope'.ucfirst($scope) ) );
    }

    public function assertIsDateAttribute( $attr, $obj = NULL ) {
        if ( $obj == NULL) {
            $obj = $this->model;
        }
        $this->assertContains( $attr, $obj->getDates(), 'Attribute '.$attr.' is not defined as a date' );
    }

    protected function assertHasRelation($assoc, $obj) {
        $this->assertTrue( method_exists($obj, $assoc), 'Relation '.$assoc.' is not defined' );
    }

    protected function assertBelongsTo($assoc, $obj = NULL) {
        if ( $obj == NULL) {
            $obj = $this->model;
        }
        $this->assertHasRelation($assoc,$obj);
        $ret = call_user_func(array($obj,$assoc));
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $ret);
    }

    protected function assertHasMany($assoc, $obj = NULL) {
        if ( $obj == NULL) $obj = $this->model;
        $this->assertHasRelation($assoc,$obj);
        $ret = call_user_func(array($obj,$assoc));
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\HasMany', $ret);
    }

    protected function assertHasOne($assoc, $obj = NULL) {
        if ( $obj == NULL) $obj = $this->model;
        $this->assertHasRelation($assoc,$obj);
        $ret = call_user_func(array($obj,$assoc));
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\HasOne', $ret);
    }

}