
export default function Create({ auth }) {
    return (

      <div classname="container">
        <div classname="row">
          <div classname="col col-md-offset-3 col-md-6">
            <nav classname="panel panel-default">
              <div classname="panel-heading">フォルダを追加する</div>
              <div classname="panel-body">
                {/*
                if(errors.any(){
                  <div classname="alart alart-danger">
                    <ul>
                      @foreach($errors->all() as $message)
                      <li>{{ $message }}</li>
                      @endforeach
                    </ul>
                  </div>
                }
                */}
                <form action={ route('books.create') } method="post">
                  csrf
                  <div classname="form-group">
                    <label for="title">フォルダ名</label>
                    <input type="text" classname="form-control" name="title" id="title" value="{ old('title') }"/>
                  </div>
                  <div classname="text-right">
                    <button type="submit" class="btn btn-primary">送信</button>
                  </div>
                </form>
              </div>
            </nav>
          </div>
        </div>
      </div>
    );
}  