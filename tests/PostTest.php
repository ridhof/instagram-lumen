<?php
class PostTest extends TestCase
{
    /**
     * /post [GET]
     * to get all post from all users
     */
    public function testShouldReturnAllPosts(){
        $this->get("/api/v1/post", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'id_post',
                    'username',
                    'tanggal',
                    'caption'
                ]
            ]
        ]);
    }
    /**
     * /post/thumbnail/{username} [GET]
     * to get all thumbnail of post from certain user
     */
    public function testReturnAllThumbnailByCertainUser(){
        $this->get("/api/v1/post/thumbnail/ridho", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'id_gambar',
                    'url_gambar'
                ]
            ]
        ]);
    }

    /**
     * /post/{id} [GET]
     * to get a post based on its id 
     */
    public function testReturnPostById(){
        $this->get("/api/v1/post/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => 
                [
                    'id_post',
                    'username',
                    'tanggal',
                    'caption',
                    'jumlah_like',
                    'gambar' => ['*' => 
                        [
                            'id_gambar',
                            'url_gambar'
                        ]
                    ],
                    'komentar' => ['*' => 
                        [
                            'id_komen',
                            'username',
                            'isi_komen'
                        ]
                    ]
                ]
        ]);
    }

    /**
     * /komentar [POST]
     * to send a comment on certain post id
     */
    public function testCreateComment(){
        $parameters = [
            'commenting_username' => 'ridho',
            'id_post' => 1,
            'komentar' => 'keren, lanjutkan!'
        ];

        $this->post("/api/v1/komentar", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'status',
                    'id_komen',
                    'commenting_username',
                    'id_post',
                    'komentar',
                    'tanggal'
                ]
            ]
        );
    }

    /**
     * /like/{id_post}/{username} [GET]
     * to get whether certain user already like a post or not
     */
    public function testGetLikeCertainUser(){
        $this->get("/api/v1/like/1/ridho", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => 
                [
                    'id_post',
                    'liking_username',
                    'like'
                ]
        ]);
    }

    /**
     * /like [POST]
     * to send a like on certain post id
     */
    public function testCreateLike(){
        $parameters = [
            'liking_username' => 'ridho',
            'id_post' => 1,
            'like' => 1
        ];

        $this->post("/api/v1/like", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'status',
                    'id_post',
                    'liking_username',
                    'like'
                ]
            ]
        );
    }

    /**
     * /products/id [PUT]
     */
    // public function testShouldUpdateProduct(){
    //     $parameters = [
    //         'product_name' => 'Infinix Hot Note',
    //         'product_description' => 'Champagne Gold, 13M AF + 8M FF 4G Smartphone',
    //     ];
    //     $this->put("products/4", $parameters, []);
    //     $this->seeStatusCode(200);
    //     $this->seeJsonStructure(
    //         ['data' =>
    //             [
    //                 'product_name',
    //                 'product_description',
    //                 'created_at',
    //                 'updated_at',
    //                 'links'
    //             ]
    //         ]    
    //     );
    // }
    /**
     * /products/id [DELETE]
     */
    // public function testShouldDeleteProduct(){
        
    //     $this->delete("products/5", [], []);
    //     $this->seeStatusCode(410);
    //     $this->seeJsonStructure([
    //             'status',
    //             'message'
    //     ]);
    // }

}