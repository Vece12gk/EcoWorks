function completarMissao(idMissao) {
  fetch('php/addPoints.php?id=' + idMissao)
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      location.reload();
    });
}
