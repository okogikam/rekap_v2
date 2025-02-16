<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Penelitian</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control input">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div id="result"></div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
 <script>
    let resultPage = document.querySelector("#result");
    let btnSubmit = document.querySelector(".submit");
    btnSubmit.addEventListener("click",async ()=>{
        resultPage.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
        let input = document.querySelector(".input").value;
        try{
            let response = await fetch(`http://localhost/rekap_v2/pages/api/penelitian_api.php?id=${input}`);
            // let responseJSON = await response.json();
            console.log(`${JSON.stringify(response)}`);
            resultPage.innerHTML = `${response.json()}`;
        }catch(e){
            resultPage.innerHTML = `error: ${e}`;
        }
    })
 </script>