<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BootStrap 測試</title>
<!-- 最新編譯和最佳化的 CSS -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="/sys/css/bootstrap.min.css">
 <!-- 選擇性佈景主題 -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css"> -->
<link rel="stylesheet" href="/sys/css/bootstrap-theme.min.css">
 <!-- 最新編譯和最佳化的 JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script></head> -->
<script src="/sys/js/bootstrap.min.js"></script></head>
<body>
<div class="container">
    <p class="lead">col測試</p>
    <div class="row show-grid">
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
      <div class="col-md-1">.col-md-1</div>
    </div>
    <div class="row show-grid">
      <div class="col-md-8">.col-md-8</div>
      <div class="col-md-4">.col-md-4</div>
    </div>
    <div class="row show-grid">
      <div class="col-md-4">.col-md-4</div>
      <div class="col-md-4">.col-md-4</div>
      <div class="col-md-4">.col-md-4</div>
    </div>
    <div class="row show-grid">
      <div class="col-md-6">.col-md-6</div>
      <div class="col-md-6">.col-md-6</div>
    </div>
</div>
<div class="container">
    <p class='lead'>h1~6測試</p>
    <h1>h1</h1>
    <h2>h2</h2>
    <h3>h3</h3>
    <h4>h4</h4>
    <h5>h5</h5>
    <h6>h6</h6>
</div>
<div class="container">
    <p class="lead">.lead</p>
    <mark>mark</mark>
    <del>del</del>
    <s>s</s>
    <ins>ins</ins>
    <u>u</u>
    <small>small</small>
    <strong>strong</strong>
    <em>em</em>
</div>
<div class="container">
    <p class="lead">對齊測試</p>
    <div class="text-left">.text-left</div>
    <div class="text-center">.text-center</div>
    <div class="text-right">.text-right</div>
    <div class="text-justify">.text-justify</div>
    <div class="text-nowrap">.text-nowrap</div>
</div>
<div class="container">
    <blockquote>
        <p>少小離家老大回，鄉音無改鬢毛催。兒童相見不相識，笑問客從何處來。</p>
        <footer>回鄉偶書，作者：<cite title="Source Title">賀知章</cite></footer>
    </blockquote>
</div>
<div class="container">
    <table class="table table-striped table-bordered table-hover table-responsive">
        <tr>
            <th>th</th>
            <th>th</th>
            <th>th</th>
            <th>th</th>
            <th>th</th>
        </tr>
        <tr>
            <td>td</td>
            <td>td</td>
            <td>td</td>
            <td>td</td>
            <td>td</td>
        </tr>
        <tr>
            <td class='active'>.active</td>
            <td class='success'>.success</td>
            <td class='info'>.info</td>
            <td class='warning'>.warning</td>
            <td class='danger'>.danger</td>
        </tr>
        <tr>
            <td>td</td>
            <td>td</td>
            <td>td</td>
            <td>td</td>
            <td>td</td>
        </tr>
        <tr>
            <td>td</td>
            <td>td</td>
            <td>td</td>
            <td>td</td>
            <td>td</td>
        </tr>
    </table>
</div>
<div class="container">
    <form action="">
        <div class="form-group">
            <label for="fm1">label</label>
            <input type="text" id='fm1' class='form-control' placeholder='placeholder'>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label for=""><input type="checkbox">checkbox</label>
            </div>
        </div>
        <textarea class="form-control" rows="3"></textarea>
        <div class="form-group has-success has-feedback">
            <label class="control-label" for="inputSuccess2">Input with success</label>
            <input type="text" class="form-control" id="inputSuccess2" aria-describedby="inputSuccess2Status">
            <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
            <span id="inputSuccess2Status" class="sr-only">(success)</span>
        </div>
        <div class="form-group has-warning has-feedback">
            <label class="control-label" for="inputWarning2">Input with warning</label>
            <input type="text" class="form-control" id="inputWarning2" aria-describedby="inputWarning2Status">
            <span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
            <span id="inputWarning2Status" class="sr-only">(warning)</span>
        </div>
        <div class="form-group has-error has-feedback">
            <label class="control-label" for="inputError2">Input with error</label>
            <input type="text" class="form-control" id="inputError2" aria-describedby="inputError2Status">
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            <span id="inputError2Status" class="sr-only">(error)</span>
        </div>
    </form>
</div>
<div class="container">
    <!-- 標準按鈕 -->
    <button type="button" class="btn btn-default">Default</button>

    <!-- 提供額外視覺上的重量和識別一組按鈕中主要的操作項目 -->
    <button type="button" class="btn btn-primary">Primary</button>

    <!-- 指出成功或積極的操作 -->
    <button type="button" class="btn btn-success">Success</button>

    <!-- 訊息提示方面的操作 -->
    <button type="button" class="btn btn-info">Info</button>

    <!-- 指出應謹慎採取此一行動 -->
    <button type="button" class="btn btn-warning">Warning</button>

    <!-- 指出危險或潛在負面作用的行動 -->
    <button type="button" class="btn btn-danger">Danger</button>

    <!-- 淡化一個按鈕，使它看起來像是一個連結並同時保持按鈕行為 -->
    <button type="button" class="btn btn-link">Link</button>
</div>
<div class="container">
    <p>
      <button type="button" class="btn btn-primary btn-lg">Large button</button>
      <button type="button" class="btn btn-default btn-lg">Large button</button>
    </p>
    <p>
      <button type="button" class="btn btn-primary">Default button</button>
      <button type="button" class="btn btn-default">Default button</button>
    </p>
    <p>
      <button type="button" class="btn btn-primary btn-sm">Small button</button>
      <button type="button" class="btn btn-default btn-sm">Small button</button>
    </p>
    <p>
      <button type="button" class="btn btn-primary btn-xs">Extra small button</button>
      <button type="button" class="btn btn-default btn-xs">Extra small button</button>
    </p>
</div>
<div class="container">
    <div><img src="/sys/img/1.jpg" alt="1.jpg" class='img-rounded'></div>
    <div><img src="/sys/img/1.jpg" alt="1.jpg" class='img-circle'></div>
    <div><img src="/sys/img/1.jpg" alt="1.jpg" class='img-thumbnail'></div>
</div>
<div class="container">
    <span class="caret"></span>
</div>
<div class="container">
    <div class="pull-left">.pull-left</div>
    <div class="pull-right">.pull-right</div>
</div>
<div class="container">
    <div class="center-block"><button class="btn" >button</button></div>
</div>
</body>
</html>