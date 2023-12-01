import '../../css/styles.css';

export default function Tuzuki({value}) {
/*  
  const  segmenterJa = new Intl.Segmenter('ja-JP', { granularity: 'grapheme' });
  const  segments = segmenterJa.segment({value});
  console.log(Array.from(segments).length);
  const  len = (Array.from(segments).length);
*/ 
  const  lenflg = (value.length > 150);

  return (  
    <div class="read-more-002">
      {lenflg ? (<p>{value ? value : ''}</p>) : (<div class="p1">{value ? value : ''}</div>)}
      {lenflg ? (
      <label>
        <input type="checkbox"/>
          ...続きを読む
      </label>
      ) : ''}
    </div>
  );
}