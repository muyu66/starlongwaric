<?php

class StoryTest extends TestCase
{
    public function testIndex()
    {
        $this->get_with_login('stories');
        $this->seeJsonContains(['id' => 1]);
    }

    public function testShow()
    {
        $this->get_with_login('stories/2');
        $this->seeJsonContains(['id' => 2]);
    }
}