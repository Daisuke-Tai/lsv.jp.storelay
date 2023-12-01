import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import InputModal from '@/Components/InputModal';
import Tuzuki from '@/Components/Tuzuki';

export default function Index({ auth,kinds,current_kind_id,books }) {
    const [show1, setShow1] = useState(false);
    const [show2, setShow2] = useState(false);
    const [show3, setShow3] = useState(false);
    
    return (

        <AuthenticatedLayout user={auth.user}>

          <div className="flex h-screen">
            
            {/* サイドバー*/}
            <div className="hidden w-40 overflow-y-auto md:block flex-shrink-0">
              <nav className="bg-violet-100 mt-2 pt-2">
                <div className="bg-blue-300 mt-2 mb-2 px-2">ジャンル</div>
                <div>
                  <button onClick={() => setShow1(true)} 
                    className="inline-block rounded border border-current px-2 text-sm font-medium text-indigo-500 transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:text-indigo-500">
                    ジャンルを作成</button>
                  <InputModal type={1} show={show1} setShow={setShow1}>
                    <p>Childrenを使っています。</p>
                  </InputModal>
                </div>
                <div className="mt-2">
                  
                  {kinds.map((kind) =>(
                    <a key={kind.id} href={ route('books.index', {'kind_id': kind.id}) } 
                    className="flex hover:bg-violet-300 focus:bg-violet-300 { current_kind_id === kind.id ? 'bg-violet-400' : '' }">
                      <span class="mx-2">
                        { kind.name }
                      </span>
                      <span class="flex-grow text-right"></span>
                    </a>                      
                  ))}
                </div>
              </nav>
            </div>
            
            {/* 真ん中*/}
            <div className="bg-violet-200 flex-grow w-full h-full mt-2 px-2 overflow-y-auto">   
              <div className="bg-white pt-2">
                  <div className="bg-blue-400 mt-2 mb-2 px-2">ストーリー</div>
                  <div className="mb-2 px-2">
                      <div className="items-left">
                        <button onClick={() => setShow2(true)} className="inline-block rounded border border-current px-2 text-sm font-medium text-indigo-600 transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:text-indigo-500">ストーリーをはじめる</button>
                        <InputModal type={2} show={show2} setShow={setShow2} kind_id={current_kind_id}/>
                      </div>
                  </div>
                  <div className="w-full">

                      {books.map((book) => (

                        <div key={book.id} className="relative -mt-px mx-1 px-1 border-collapse border hover:bg-violet-200 focus:bg-violet-200">
                          <a href={ route('books.index2', {'id': book.id})} className="flex w-full h-full">
                            <tbody >
                              <tr>
                                <td className="whitespace-pre-line">                                     
                                  <Tuzuki value={ book.story } />
                                </td>
                              </tr>
                              <tr>  
                                <td> 
      
                                  <input id="b_relay"  type="checkbox" className="hidden"></input> 
                                  <label for="b_relay" onClick={() => setShow3(true)} className=" z-1 px-2 mb-1 rounded border border-current text-sm font-medium text-indigo-600 hover:scale-150 hover:shadow-xl focus:outline-none focus:ring active:text-green-500">リレー</label>                                  
                                  <InputModal type={3} show={show3} setShow={setShow3} id={book.id}/>  
{/*                                   
                                  <button  className="z-1 inline-block rounded border border-current px-2 text-sm font-medium text-indigo-600 transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:text-indigo-500">relay</button>
                                  <InputModal type={3} show={show3} setShow={setShow3} id={book.id}/>    
*/} 
                                </td>
                              </tr>
                            </tbody>
                            </a>        
                        </div>
                      ))}
                      
                  </div>
              </div>
            </div>
            
            {/* 3つ目*/}
            <div className="grow w-80 mt-2 pt-2 pl-2 space-y-2 bg-violet-300 hidden md:block">
              <div className="bg-white mt-2 pt-2">
                aa
              </div>
              <div className="bg-white mt-2 pt-2">
                bb
              </div>
              
            </div>
          </div>

        
        </AuthenticatedLayout>       
    );
}
