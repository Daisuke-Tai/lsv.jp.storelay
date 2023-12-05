import { useForm } from '@inertiajs/react';
import { useEffect } from 'react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';

export default function InputModal(props) {
  const { data, setData, post, processing, errors, reset } = useForm({
    story: '',
  });

  useEffect(() => {
      return () => {
          reset('story');
      };
  }, []);

  const closeModal = () => {
    
    switch(props.type){
      case 1 : // ジャンル作成
        props.setShow(false);
        break;
      case 2 : // ブック作成
        props.setShow(false);
        break;
      case 3 : // リレー
        props.setAtag(false);  
        props.setShow(0);
        break;    
    };
  };

  const submit = (e) => {
      e.preventDefault();
      
      switch(props.type){
        case 1 : // ジャンル作成
          post(route('kinds.create'));
          break;
        case 2 : // ブック作成
          post(route('books.create',{'kind_id': props.kind_id}));
          break;
        case 3 : // リレー
          post(route('books.relay', {'id': props.id}));
          break;
      };  

      closeModal();
  };  
  
  if (props.show) {
    return (
       
      <div className="fixed flex top-0 left-0 z-10 w-full h-full bg-violet-500/50 justify-center items-center" onClick={closeModal}>
        
        <div className="relative z-20 max-w-full p-2 max-h-full bg-blue-200 rounded-lg" onClick={(e) => e.stopPropagation()}>
          <form className="flex flex-col" onSubmit={submit}>
              
              <InputLabel htmlFor="story" value={props.children} />
              
              <label className="h-full w-full" for="story">
                <textarea 
                  id="story"
                  type="submit"
                  name="story"
                  value={data.story}
                  className="w-[500px] h-[300px] resize text-base text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" 
                  placeholder="Enter your comment Enter your comment" 
                  onChange={(e) => setData('story', e.target.value)}
                >
                </textarea>
              </label>
              <InputError message={errors.story} className="mt-2" />
              <div className="flex">
                <span class="flex-grow"/>
                <PrimaryButton className="w-16" disabled={processing}>
                  つくる
                </PrimaryButton>
              </div>
                          
          </form>
        </div>
      </div>

    );
  } else {
    return null;
  }
}