<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kind;
use App\Models\Book;
use Sequence;
//use App\Facades\Sequence;
use App\Http\Requests\CreateBook;
use App\Http\Requests\EditBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BookController extends Controller
{

    const key = ['create' => 'b', 'relay' => 'bp'];

    // 一覧表示
    public function index(int $kind_id){
       
//         kindモデルのallクラスメソッドですべて取得
        $kinds = Kind::all();

        // 選択されたフォルダを取得
        $current_kind = Kind::find($kind_id);

        // 選択されたフォルダに紐づくタスクを取得
        $books = Book::withCount('likes')->withExists('isLike')
                     ->withCount('hates')->withExists('isHate')
                     ->where('kind_id', $current_kind->id)->latest('id')->get();

        // クエリビルダで取得するとModelが意味をなさなくなり
        // view側のカラムに変なカラム名があるとエラーになる。
        // eloquentではエラーにならないときがある。
//        $books = DB::table('books')->orderBy('id', 'desc')->get();

        // 'kinds'がキー、$kindsが代入値
//        return Inertia::render('Dashboard');
        
        return Inertia::render('Books/Index', [
 //       return view('books/index', [
            'kinds' => $kinds,
            'current_kind_id' => $current_kind->id,
            'books' => $books,
        ]);
        
    }

    public function index2(int $id){
       
//         kindモデルのallクラスメソッドですべて取得
        $kinds = Kind::all();

        // 選択されたフォルダを取得
        $current_kind = Book::find($id);

        // 選択されたフォルダに紐づくタスクを取得
        $books = Book::where('kind_id', $current_kind->kind_id)
                     ->where('tema_id', $current_kind->tema_id)
                     ->where('page_no', $current_kind->page_no+1)
                     ->orwhere('id', $current_kind->id)
                     ->latest('id')->get();

        return Inertia::render('Books/Index', [
    //       return view('books/index', [
            'kinds' => $kinds,
            'current_kind_id' => $current_kind->kind_id,
            'books' => $books,
        ]);
                
    }
        
    // タイトル作成画面表示(use CreateBookは必要ない)
    public function showCreateForm(int $kind_id){
        return view('books/create', [
            'kind_id' => $kind_id
        ]);
    }

    // 作成（use CreateBookが必要。requestのため）
    public function create(int $kind_id, CreateBook $request){

        $current_kind = Kind::find($kind_id);        
        $kind_name = 'tema_id(' .$current_kind->name .')';
        
        
        try{
            DB::beginTransaction();
            // 1 採番
            $num = Sequence::getNewNo($kind_name, 0, 0);

            // 3 insert
            $book2 = new Book();
            $params = [
                'kind_id' => $kind_id,
                'tema_id' => $num,
                'page_no' => 1, 
                'post_id' => 1 ,
                'story' => $request->story,
                'root' => str_pad(1, 3, '0', STR_PAD_LEFT), 
                'user_id' => Auth::user()->id, 
                'del_f' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $wk_up = DB::table('books')->insert($params);
            DB::commit();
        } catch ( \RuntimeException $e ) {
            DB::rollback(); // 番号も巻き戻る
        }
/*
        $subSQL = 

        $subQuery = Book::where("ITEM_ID", "<", ":ITEM_ID")
                   ->groupBy("ITEM_ID")
                   ->select("ITEM_ID",
                            DB::raw("COUNT(*) AS SOLD_COUNT"))
                   ->toSql();

        $book = new Book();
        $book->tema_id = 1;
        $book->page_no = 0;
        $book->post_id = 0;
        $book->kind_id = $id;
        $book->user_id = 1;
        $book->del_f = 0;
        $book->root = 'FF';

        $book->story = $request->story;
//        $book->due_date = $request->due_date;

        $current_kind->books()->save($book);

            DB::table('pruned_users')->insertUsing([
                'id', 'name', 'email', 'email_verified_at'
            ], DB::table('users')->select(
                'id', 'name', max('email')+1, 'email_verified_at'
            )
            ->where('updated_at', '<=', ':aaa' ) 
            ->setBindings([':aaa', '=', '100']));
*/

/* SQL1 かんせい */
/*
        $sql = DB::table('books')->select(
            'tema_id', 'page_no', 'post_id' , 'story', 'kind_id', 'root', 'user_id', 'del_f', 'created_at', 'updated_at'
        )
        ->where([
            ['tema_id', '=', ':tema_id'],
            ['page_no', '=', ':page_no'],
        ] )
        ->setBindings([
            [':tema_id' => '1'],
            [':page_no' => '2'],
        ])
        ->latest('post_id')
        ->first();


        $params = ['story' => $request->story, 'user_id' => $user->id, 'id' => 6];
        DB::insert('INSERT INTO books(tema_id, page_no, post_id , story, kind_id, root, user_id, del_f, created_at, updated_at) 
                    SELECT  tema_id, 
                            page_no + 1, 
                            post_id + 1 , 
                            :story, 
                            kind_id, 
                            root, 
                            :user_id, 
                            del_f, 
                            NOW(), 
                            NOW()  
                    FROM books
                    WHERE tema_id = :tema_id 
                    AND   page_no = :page_no '
                    , $params);

        $sql = DB::table('books')->select(
            'tema_id', 'page_no', 'post_id'+1 , 'story', 'kind_id', 'root', 'user_id', 'del_f', 'created_at', 'updated_at'
        )
        ->where([
            ['tema_id', '=', ':tema_id'],
            ['page_no', '=', ':page_no'],
        ] )
        ->setBindings([
            [':tema_id' => '1'],
            [':page_no' => '2'],
        ])
        ->latest('post_id')
        ->first();
*/
/*
        DB::table('books')->insertUsing([
            'tema_id', 'page_no', 'post_id', 'story', 'kind_id', 'root', 'user_id', 'del_f', 'created_at', 'updated_at'
        ], DB::table('books')->select(
            'tema_id', 'page_no', 'post_id', 'story', 'kind_id', 'root', 'user_id', 'del_f', 'created_at', 'updated_at'
        )
        ->where([
            ['tema_id', '=', ':tema_id'],
            ['page_no', '=', ':page_no'],
        ] )
        ->setBindings([
            [':tema_id' => '1'],
            [':page_no' => '2'],
        ]));
 */

        
        return redirect()->route('books.index', [
            'kind_id' => $current_kind->id,
        ]);
    }

    // リレー作成画面表示(use CreateBookは必要ない)
    public function showRelayForm(int $id){
        return view('books/relay', [
            'id' => $id,
            //'tema_id' => $tema_id,
            // 'book' => $book,*/
        ]);
    }

    public function relay(int $id, CreateBook $request){
        
        // 1 select
        $book1 = DB::table('books')->find($id);

        $current_kind = Kind::find($book1->kind_id);        
        $kind_name = 'post_id(' .$current_kind->name .')';

        try{
            DB::beginTransaction();
    
            // 2 採番
            $num = Sequence::getNewNo($kind_name, $book1->tema_id, $book1->page_no+1);

            // 3 insert
            $book2 = new Book();
            $params = [
                'tema_id' => $book1->tema_id,
                'page_no' => $book1->page_no+1, 
                'post_id' => $num ,
                'story' => $request->story,
                'kind_id' => $book1->kind_id,
                'root' => $book1->root, 
                'user_id' => Auth::user()->id, 
                'del_f' => $book1->del_f,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $wk_up = DB::table('books')->insert($params);
            DB::commit();
        } catch ( \RuntimeException $e ) {
            DB::rollback(); // 番号も巻き戻る
        }

        return redirect()->route('books.index', [
            'kind_id' => $book1->kind_id,
        ]);
    }


    public function showEditForm(int $kind_id, int $id){
        $book = Book::find($id);

        return view('books/edit', [
            'book' => $book,
        ]);
    }

    public function edit(int $kind_id, int $tema_id, EditBook $request){
        // 1
        $book = Book::find($tema_id);
        // 2
        $book->title = $request->title;
        $book->status = $request->status;
        $book->due_date = $request->due_date;
        $book->save();
        // 3
        return redirect()->route('books.index', [
            'kind_id' => $book->kind_id,
        ]);
    }
}
