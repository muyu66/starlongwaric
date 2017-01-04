<?php

class StoryTest extends TestCase
{
    public function testIndex()
    {
        $this->login();
        $this->get('story');
        $this->see('chapter');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->login();
        $this->get('story/1');
        $this->see('chapter');
        $this->seeJson();
        $this->assertResponseOk();
    }
}