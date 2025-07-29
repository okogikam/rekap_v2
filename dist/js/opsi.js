
async function showData(page){
  let mainElemen = document.querySelector(".content"); 
  let div = document.createElement("div");
  div.setAttribute("id","modal");
  let response = await fetch(`http://localhost/rekap_v2/pages/api/api.php?p=${page.page}&id=${page.id}&type=${page.type}`);
  let data =  await response.json();
  div.innerHTML = `
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Data ${page.page}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form id="form-data">
               
	  <form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>`
  Object.values(data.data[0]).forEach((i,v) =>{
  let divForm = document.createElement("div");
  divForm.innerHTML = `<div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-secondary">${Object.keys(data.data[0])[v]}</label>
        </div>
        <input type="text" class="form-control" value="${i}" name="${Object.keys(data.data[0])[v]}" disabled>
   </div> `
   div.querySelector("#form-data").appendChild(divForm);
  })

  div.querySelectorAll("[data-dismiss=modal]").forEach(bt => {addEventListener("click",()=>{
     div.remove();
  })});
  mainElemen.appendChild(div);
  console.log(data);
}
async function editData(page){
  let mainElemen = document.querySelector(".content"); 
  let div = document.createElement("div");
  div.setAttribute("id","modal");
  let response = await fetch(`http://localhost/rekap_v2/pages/api/api.php?p=${page.page}&id=${page.id}&type=${page.type}`);
  let data =  await response.json();
  div.innerHTML = `
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Data ${page.page}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form id="form-data">
               
	  <form>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-primary save">Save</button>
      </div>
    </div>
  </div>`
  Object.values(data.data[0]).forEach((i,v) =>{
  let divForm = document.createElement("div");
  divForm.innerHTML = `<div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-secondary">${Object.keys(data.data[0])[v]}</label>
        </div>
        <input type="text" class="form-control" value="${i}" name="${Object.keys(data.data[0])[v]}">
   </div> `
   div.querySelector("#form-data").appendChild(divForm);
  })

  div.querySelector(".save").addEventListener("click", async ()=>{
     let formData = div.querySelector("#form-data");
     let response = await fetch(`http://localhost/rekap_v2/pages/api/api.php?p=${page.page}&id=${page.id}&type=${page.type}`);
     let data =  await response.json();
     console.log(data)
  });
  div.querySelector(".close").addEventListener("click",()=>{
     div.remove();
  });
  mainElemen.appendChild(div);
  console.log(data);
}
async function deleteData(page){
   let mainElemen = document.querySelector(".content"); 
  let div = document.createElement("div");
  div.setAttribute("id","modal");
  let response = await fetch(`http://localhost/rekap_v2/pages/api/api.php?p=${page.page}&id=${page.id}&type=${page.type}`);
  let data =  await response.json();
  div.innerHTML = `
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Data ${page.page}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form id="form-data">
               <p>Apa anda yakin akan menghapus data ini?</p>
	  <form>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>`
  div.querySelector(".close").addEventListener("click",()=>{
     div.remove();
  });
  mainElemen.appendChild(div);
  console.log(data);
}