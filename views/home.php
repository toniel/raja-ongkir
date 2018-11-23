<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cek Ongkir</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container py-5">
		<div class="row">
			<div class="col-md-12">
				<h1 class="text-center">Cek Ongkos Kirim TIKI,JNE,dan POS</h1>
				<form>
					<h3>Kota Asal</h3>
					  <div class="form-group">
					    <label for="formGroupExampleInput">Provinsi</label>
					    <select id="provinsi_asal" class="form-control provinsi" onChange="get_kabupaten('asal')" >
					    	<option value="" disabled selected >===PILIH PROVINSI===</option>
					    </select>
					  </div>
					  <div class="form-group">
					    <label for="formGroupExampleInput2">Kabupaten</label>
					   	<select name="" id="kabupaten_asal" class="
					   	form-control">
					   		<option value="" disabled selected >===PILIH KABUPATEN===</option>
					   		
					   	</select>
					  </div>
					  <h3>Kota Tujuan</h3>
					  <div class="form-group">
					    <label for="formGroupExampleInput">Provinsi</label>
					    <select id="provinsi_tujuan" class="form-control provinsi" onChange="get_kabupaten('tujuan')" >
					    	<option value="" disabled selected >===PILIH PROVINSI===</option>
					    </select>
					  </div>
					  <div class="form-group">
					    <label for="formGroupExampleInput2">Kabupaten</label>
					   	<select name="" id="kabupaten_tujuan" class="
					   	form-control">
					   		<option value="" disabled selected >===PILIH KABUPATEN===</option>
					   		
					   	</select>
					   		
					   </div>

					   <h3>Ongkos Kirim</h3>
						
						<div class="form-group">
					   		<label for="">Berat (bulatkan dalam kg)</label>
					   		<input type="number" id="berat" name="berat" class="form-control" >
					   	</div>
					   	<div class="form-group">
					   	  <label for="formGroupExampleInput">Kurir</label>
					   	  <select onchange="cek_biaya()" name="kurir" class="form-control" id="kurir">
   	                         <option value="" selected="true" disabled="true">Pilih Kurir Pengiriman</option>
   	                         <option value="jne">JNE</option>
   	                         <option value="tiki">TIKI</option>
   	                         <option value="pos">POS</option>
   	                     </select>

					   	</div>
					   

					   	<div class="form-group">
					   	  <label for="formGroupExampleInput">Service</label>
					   	  <select onchange="total()" name="service" class="form-control" id="service">
   	                         <option value="" selected="true" disabled="true">Pilih Kurir Service</option>
   	           
   	                     </select>

					   	</div>	

					   	<div class="form-group">
					   		<label for="total">Total</label>
					   		<input disabled type="text" id="total" name="total" class="form-control" >
					   	</div>			 
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			$.get("<?= site_url('welcome/get_provinsi/') ?>",{},(response)=>{
				// console.log(response.rajaongkir.results)
				let provinces = response.rajaongkir.results;
				let output = "";
				$.each(provinces,(key,val)=>{
					output+=`
							<option value="${val.province_id}" >${val.province}</option>
					`;
				})
				$('.provinsi').html(output)
			})
		});

		function get_kabupaten(type){
			let id_provinsi = $(`#provinsi_${type}`).val();
			console.log(id_provinsi)
			$.get("<?= site_url('welcome/city/') ?>"+id_provinsi,{},(response)=>{
				let kabupaten = response.rajaongkir.results;
				let output = ""
				kabupaten.map((val,i)=>{
					output+=`
						<option value="${val.city_id}" >${val.city_name}</option>
					`
				});
				$(`#kabupaten_${type}`).html(output)
			})
		}

		function cek_biaya(){
			let berat = $('#berat').val();
			let asal = $('#kabupaten_asal').val();
			let tujuan = $('#kabupaten_tujuan').val();
			let kurir = $('#kurir').val();
			let output = ""

			$.get("<?= site_url('welcome/cek_ongkir/') ?>"+`${asal}/${tujuan}/${berat}/${kurir}`,{},(response)=>{

				let biaya = response.rajaongkir.results;
				console.log(biaya)
				biaya.map((val,i)=>{
					for (var i = 0; i < val.costs.length; i++) {
						let jenis_layanan = val.costs[i].service;
						val.costs[i].cost.map((val,i)=>{
							  output += `
                <option value="${val.value}">${jenis_layanan} - Rp.${val.value} (${val.etd} Hari)</option>
              `;

						})
					}
				  $('#service').html(output);
				})
				 let service = $('#service option:selected').text();
                    $('input[name=service]').val(service);

			
				
			})

		}

		function total(){

		}

	</script>

</body>
</html>
