<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Cari NOP</title>
<link rel="stylesheet" href="style1.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
  margin:0;
  font-family:sans-serif;
  color:white;
}

/* TOPBAR */
.topbar{
  position: fixed;
  top:0;
  left:0;
  width:100%;
  display:flex;
  justify-content: space-between;
  align-items:center;
  padding:10px 15px;
  background: rgba(0,0,0,0.4);
  backdrop-filter: blur(8px);
  z-index:999;
}

.topbar a{
  text-decoration:none;
  color:white;
  padding:6px 12px;
  border-radius:8px;
  font-size:13px;
  transition:0.2s;
}

.topbar a:hover{
  background: rgba(255,255,255,0.2);
}

/* CONTAINER */
.container{
  max-width:700px;
  margin:auto;
  margin-top:90px;
  padding:15px;
  text-align:center;
}

/* TITLE */
h2{
  margin-bottom:15px;
}

/* SEARCH */
.search-box{
  margin-bottom:15px;
}

.search-box input{
  width:100%;
  padding:12px;
  border-radius:10px;
  border:none;
  font-size:16px;
  outline:none;
}

/* RESULT */
.card-result{
  background: rgba(255,255,255,0.1);
  margin-top:10px;
  padding:15px;
  border-radius:12px;
  text-align:left;
  backdrop-filter: blur(5px);
}

.card-result h3{
  margin:0 0 5px;
}

.card-result p{
  margin:2px 0;
}

/* BUTTON EDIT */
.btn-edit{
  display:inline-block;
  margin-top:8px;
  padding:5px 10px;
  background:#ff9800;
  color:white;
  text-decoration:none;
  border-radius:6px;
  font-size:12px;
}

/* MOBILE */
@media(max-width:600px){
  .topbar{
    flex-direction: column;
    gap:5px;
  }

  .container{
    margin-top:120px;
    padding:10px;
  }

  .search-box input{
    font-size:14px;
  }
}
</style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">

  <a href="index.php">🏠 Home</a>

  <div>
    <?php if(isset($_SESSION['login'])){ ?>
      <a href="admin.php">📊 Dashboard</a>
      <a href="logout.php">🚪 Logout</a>
    <?php } else { ?>
      <a href="login.php">🔐 Login</a>
    <?php } ?>
  </div>

</div>

<!-- CONTENT -->
<div class="container">

<h2>Cari NOP / Nama</h2>

<div class="search-box">
  <input type="text" id="searchInput" placeholder="Ketik NOP / Nama...">
</div>

<div id="hasil"></div>

</div>

<script>
const input = document.getElementById("searchInput");
const hasil = document.getElementById("hasil");

const isLogin = <?= isset($_SESSION['login']) ? 'true' : 'false' ?>;

let timer;

input.addEventListener("keyup", function(){
  clearTimeout(timer);

  let q = input.value;

  if(q.length < 1){
    hasil.innerHTML = "";
    return;
  }

  hasil.innerHTML = "<p style='text-align:center;'>Mencari...</p>";

  timer = setTimeout(() => {

    fetch("search.php?q=" + q)
      .then(res => res.json())
      .then(data => {

        if(data.length === 0){
          hasil.innerHTML = "<p style='text-align:center;'>Tidak ditemukan</p>";
          return;
        }

        hasil.innerHTML = data.map(d => `
          <div class="card-result">
            <h3>${d.nama}</h3>
            <p>NOP: ${d.nop}</p>
            <p>${d.alamat}</p>
            ${isLogin ? `<a href="edit.php?id=${d.id}" class="btn-edit">Edit</a>` : ''}
          </div>
        `).join("");

      });

  }, 300);

});
</script>

</body>
</html>