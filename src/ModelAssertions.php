<?php namespace SilvertipSoftware\LaravelTestHelpers;

trait ModelAssertions {

    public function assertIsAModel() {
        $class = $this->getClassUnderTest();
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Model', new $class() );
    }

    public function assertIsValid( $obj = NULL ) {
        if ( $obj == NULL )
            $obj = $this->model;
        $this->assertTrue( $obj->isValid(), 'Model is invalid with: ' . $this->errors );
    }

    public function assertIsInvalid( $obj = NULL ) {
        if ( $obj == NULL )
            $obj = $this->model;
        $this->assertFalse( $obj->isValid(), 'Model should be invalid' );
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
        $this->assertTrue($ret instanceof \Illuminate\Database\Eloquent\Relations\HasMany
            || $ret instanceof \Illuminate\Database\Eloquent\Relations\MorphMany, $assoc . ' relation is not a one-to-many');
    }

    protected function assertHasOne($assoc, $obj = NULL) {
        if ( $obj == NULL) $obj = $this->model;
        $this->assertHasRelation($assoc,$obj);
        $ret = call_user_func(array($obj,$assoc));
        $this->assertTrue($ret instanceof \Illuminate\Database\Eloquent\Relations\HasOne 
            || $ret instanceof \Illuminate\Database\Eloquent\Relations\MorphOne, $assoc . ' relation is not a one-to-one');
    }
}
