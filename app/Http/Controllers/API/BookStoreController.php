<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStore\StoreRequest;
use App\Http\Requests\BookStore\UpdateRequest;
use App\Models\BookStore;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookStoreController extends Controller
{
    use ApiResponse;

    /**
    * @OA\Get(
    *     path="/api/book-stores",
    *     summary="Lista de livros",
    *     tags={"Livros"},
    *     security={{"bearerAuth":{}}},
    * @OA\Response(
    *     response=200,
    *     description="Lista de livros"
    *   ),
    * )
    */
    public function index(Request $request)
    {
        return $this->success(DB::table('book_stores')->paginate(10), 'List of books');
    }

    /**
    * @OA\Get(
    *     path="/api/book-stores/{id}",
    *     summary="Lista de livros",
    *     tags={"Livros"},
    *     security={{"bearerAuth":{}}},
    * @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Buscar por livro",
    *         required=true,
    *      ),
    * @OA\Response(
    *     response=200,
    *     description="Livro"
    *   ),
    * )
    */
    public function show(Request $request)
    {
        $bookStore = BookStore::find($request->book_store);
        if(!$bookStore){
            return $this->notFound(null, 'BookStore not found');
        }

        return $this->success($bookStore, 'Book found successfully');
    }

    /**
    * @OA\Post(
    *     path="/api/book-stores",
    *     summary="Cria um livro",
    *     tags={"Livros"},
    *     @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="isbn",
    *                     type="integer"
    *                 ),
    *                 @OA\Property(
    *                     property="value",
    *                     type="decimal"
    *                 ),
    *                 example={"name":"Teste","isbn": 9783161484100, "value": 39.99}
    *             )
    *         )
    *     ),
    * @OA\Response(
    *     response=201,
    *     description="Livro criado com sucesso"
    *   ),
    * @OA\Response(
    *     response=401,
    *     description="Não Autorizado"
    *   )
    *    )
    */
    public function store(StoreRequest $request)
    {
        $bookStore = BookStore::create($request->only(['name', 'isbn', 'value']));
        return $this->create($bookStore, 'Book created successfully');
    }

    /**
    * @OA\Delete(
    *     path="/api/book-stores/{id}",
    *     summary="Deleta um livro",
    *     tags={"Livros"},
    *     security={{"bearerAuth":{}}},
    * @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID do livro",
    *         required=true,
    *      ),
    * @OA\Response(
    *     response=200,
    *     description="Livro"
    *   ),
    * )
    */
    public function destroy(Request $request)
    {
        $bookStore = BookStore::find($request->book_store);
        if(!$bookStore){
            return $this->notFound(null, 'BookStore not found');
        }
        $bookStore->delete();
        return response()->noContent();
    }

    /**
    * @OA\Post(
    *     path="/api/book-stores/{id}",
    *     summary="Atualiza um livro",
    *     tags={"Livros"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID do livro",
    *         required=true,
    *      ),
    *     @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="isbn",
    *                     type="integer"
    *                 ),
    *                 @OA\Property(
    *                     property="value",
    *                     type="decimal"
    *                 ),
    *                 example={"name":"Teste","isbn": 9783161484100, "value": 39.99}
    *             )
    *         )
    *     ),
    * @OA\Response(
    *     response=200,
    *     description="Livro atualizado com sucesso"
    *   ),
    * @OA\Response(
    *     response=401,
    *     description="Não Autorizado"
    *   ),
    * @OA\Response(
    *     response=404,
    *     description="BookStore not found"
    *   )
    *  )
    */
    public function update(UpdateRequest $request)
    {
        $bookStore = BookStore::find($request->book_store);
        if(!$bookStore){
            return $this->notFound(null, 'BookStore not found');
        }
        $name = $request->get('name');
        $isbn = $request->get('isbn');
        $value = $request->get('value');
        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($isbn){
            $data['isbn'] = $isbn;
        }
        if($value){
            $data['value'] = $value;
        }

        $bookStore = $bookStore->update($data);

        return $this->success($bookStore, 'Successfully updated');
    }
}
