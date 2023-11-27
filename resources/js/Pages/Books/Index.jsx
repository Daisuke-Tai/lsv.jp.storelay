import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import InputModal from '@/Components/InputModal';

export default function Index({ auth,kinds,current_kind_id,books }) {
    const [show, setShow] = useState(false);
    
    return (

        <AuthenticatedLayout
        user={auth.user}
//        header={<h2 className="">Dashboard!</h2>} 
        >
          <div className="">
            <div className="flex h-screen" hidden md:block>
              {/* サイドバー*/}
              <div className="hidden w-60 overflow-y-auto md:block flex-shrink-0">
                <nav className="bg-blue-100 mt-2 pt-2">
                  <div className="bg-blue-300 mt-2 mb-2 px-2">テーマ</div>
                  <div className="bg-red text-black">
                    <a href={ route('kinds.create') } className="mb-2 px-2 flex items-center space-x-4 rounded text-black bg-gradient-to-r from-green-300 to-cyan-200">
                      フォルダを追加する
                    </a>
                  </div>
                  <div>
                      <button onClick={() => setShow(true)}>Click</button>
                      <InputModal show={show} setShow={setShow}>
                        <p>Childrenを使っています。</p>
                      </InputModal>
                    </div>
                  <div className="mt-2">
                    
                    {kinds.map((kind) =>(
                      // 選択箇所をアクティブ
                      
                        <a key={kind.id} href={ route('books.index', {'kind_id': kind.id}) } 
                        className="flex items-left hover:bg-gray-300 focus:bg-gray-300 list-group-item { current_kind_id === kind.id ? 'active' : '' }">
                           <span class="mx-2">
                          { kind.name }
                          </span>
                          <span class="flex-grow text-right">
                          </span>
                        </a>
                      
                    ))}
                  </div>
                </nav>
              </div>
              
              {/* 真ん中*/}
              <div className="bg-yellow-100 flex-grow w-full h-full px-2 overflow-y-auto">
                  
                <div className="bg-white mt-2 pt-2">
                    <div className="bg-blue-400 mt-2 mb-2 px-2">ストーリー</div>
                    <div className="mb-2 px-2 flex">
                        <div className="text-right">
                        <a href={ route('books.create', {'kind_id': current_kind_id}) } className="mb-2 px-2 flex items-center space-x-4 bg-orange-300">
                            ストーリーをはじめる
                        </a>
                        </div>
                    </div>
                    <table className="table">
                        <thead>
                        <tr>
                        <th>ストーリー</th>
                        <th>状態</th>
                        <th>期限</th>
                        <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        {books.map((book) => (
                            <tr key={book.id}>
                            <td>{ book.story }</td>
                            <td>
                                <span className="label { book.status_class }">{ book.status_label }</span>
                            </td>
                            <td>{ book.formatted_due_date }</td>
                            <td><a href={ route('books.relay', {'id': book.id}) }>
                              リレー</a></td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
              </div>
              
              {/* 3つ目*/}
              <div className="grow w-80 mt-2 pt-2 pl-2 space-y-2 bg-green-100 hidden md:block">
                <div className="bg-white mt-2 pt-2">
                  aa
                </div>
                <div className="bg-white mt-2 pt-2">
                  bb
                </div>
                
              </div>
            </div>
          </div>
        </AuthenticatedLayout>       

    );
}
