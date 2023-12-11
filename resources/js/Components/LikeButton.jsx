import { useState } from 'react';
import { useEffect } from 'react';

export default function LikeButton(props) {
  const [liked, setLiked] = useState(props.type == 1 ? props.book.is_like_exists: props.book.is_hate_exists);
  const [count, setCount] = useState(props.type == 1 ? props.book.likes_count : props.book.hates_count);
  
  const like = (id) => {
     
    // laravelのエンドポイント
    const apiUrl = (props.type == 1 ? 'http://localhost/lsv.jp.storelay/public/index.php/like/'
                                    : 'http://localhost/lsv.jp.storelay/public/index.php/hate/'
                   ) + id;
    const token = document.head.querySelector('meta[name="csrf-token"]').content;

    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
      },
      body: JSON.stringify({id:id}),
    };
    console.log(requestOptions);
    
    // Postリクエストを送信
    fetch(apiUrl, requestOptions)

    .then(function(response) {
/*
      if (response.status == 419) {
        location.reload();
      }
*/
      if (!response.ok) {
        throw new Error("エラーです！！");
      }
      return response.json();
    })
    .then(data => {
//      console.log('送信！', data);
      setCount((count) => count + Number(data.result));
      setLiked(!liked);
    })
    .catch(error => {
      console.log('エラー！', error);
    });
  }

  return (
    <> 
      <input id={props.id} type="checkbox" className="hidden"></input> 
      <label for={props.id} onClick= {() => like(props.book.id)} 
        className={['mb-1 px-2 rounded border border-current text-sm font-medium',
                    'text-teal-600',
                    'hover:scale-110', 
                    'hover:shadow-xl', 
                    'focus:outline-none', 
                    'focus:ring',
                    'active:text-red-500',
                    liked ? 'bg-emerald-300' : ' '
                  ].join(' ')}
      >
        {liked ? 'o':'x'} {props.type == 1 ? 'いいね' : 'うーん' } {count}</label>

    </>
  );
}