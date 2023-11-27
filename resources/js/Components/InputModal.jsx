export default function InputModal({ show, setShow, children }) {
  const closeModal = () => {
    setShow(false);
  };
  if (show) {
    return (
      <div id="overlay" className="fixed top-0 left-0 w-full h-full bg-purple-900/40 flex items-center justify-center" onClick={closeModal}>
        <div id="content1" className="z-10 w-1/2 p-4 bg-blue-200" onClick={(e) => e.stopPropagation()}>
          {children}
          <button onClick={closeModal}>作成</button>
        </div>
      </div>
    );
  } else {
    return null;
  }
}