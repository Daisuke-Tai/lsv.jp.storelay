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
    props.setShow(false);
  };

  const submit = (e) => {
      e.preventDefault();
      
      switch(props.type){
        case 1 : // ジャンル作成
          post(route('kinds.create'));
        case 2 : // ブック作成
          post(route('books.create',{'kind_id': props.kind_id}));
        case 3 : // リレー
          post(route('books.relay', {'id': props.id}));
      };  

      closeModal();
  };  

  
  if (props.show) {
    return (
       
      <div id="overlay" className="fixed top-0 left-0 w-full h-full bg-violet-500/50 flex items-center justify-center" onClick={closeModal}>
        <div id="content1" className="z-10 w-1/2 p-4 h-1/2 bg-blue-200" onClick={(e) => e.stopPropagation()}>
          <form onSubmit={submit}>

            <div>
                <InputLabel htmlFor="story" value={props.children} />
                
                <label class="text-gray-700" for="story">
                    <textarea 
                      id="story"
                      type="submit"
                      name="story"
                      value={data.story}
                      class="flex-1 w-full px-4 py-2 text-base text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" 
                      placeholder="Enter your comment" 
                      rows="10" 
                      cols="50"
                      autoComplete="write story"
                      onChange={(e) => setData('story', e.target.value)}
                    >
                    </textarea>
                </label>

                <InputError message={errors.story} className="mt-2" />
            </div>

            <PrimaryButton className="ml-4" disabled={processing}>
              つくる
            </PrimaryButton>

          </form>
        </div>
      </div>
    );
  } else {
    return null;
  }
}