<?php

class EventStandardTest extends TestCase
{
    public function testIndex()
    {
        $this->get_with_login('event_standards');
        $this->seeJsonContains(['id' => 2]);
    }

    public function testShow()
    {
        $this->get_with_login('event_standards/1');
        $this->seeJsonContains(['id' => 1]);
    }
}