<?php
class PostTest extends TestCase
{
    /**
     * /post [GET]
     */
    public function testShouldReturnAllPosts(){
        $this->get("/api/v1/post", []);
        $this->seeStatusCode(200);
    }
    /**
     * /post/{username} [GET]
     */
    public function testReturnAllPostByCertainUser(){
        $this->get("/api/v1/post/ridho", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data'=>
                [
                    0 => 
                        [
                            'id_gambar',
                            'url_gambar'
                        ],
                    1 =>
                        [
                            'id_gambar',
                            'url_gambar'
                        ]
                ]
            ]
        );
    }
}