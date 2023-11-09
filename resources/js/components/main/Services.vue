<template>
	
	<v-container fluid fill-height class="maincontainer elevation-1 pa-1 ma-0 align-start">
		
		<v-container fluid class="pa-3">

			<div class="d-flex justify-center p-0 m-0 pt-5" id="about">
			
				<div class="" style="width: 90%">

					<h2 class="text-center text-uppercase mb-0 fw-bold">Подготовка отчетности</h2>
					<!-- Icon Divider-->
					<div class="divider-custom my-1">
						<div class="divider-custom-line"></div>
						<div class="divider-custom-icon"><i class="fa-solid fa-bolt"></i></div>
						<div class="divider-custom-line"></div>
					</div>

					<div class="row mt-6 d-flex justify-center">
						<p class="fs-5" style="text-align: justify; text-justify: inter-word;">Подготовим отчетность за Вас по приемлемым ценам.</p>
					</div>

					<v-row no-gutters>
					
						<v-col cols="12" md="6" lg="6" xl="6" class="ms-auto mt-8">
							
							<p class="font-weight-bold text-h6 text-uppercase">ХАРАКТЕРИСТИКИ:</p>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Вместимость - 4 человека (не считая экипажа)</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Длина корпуса - 6,5 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Ширина корпуса - 2,45 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Материал корпуса – стеклопластик</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Осадка - 1,25 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Водоизмещение - 1,6 т.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Подвесной двигатель</p>
								</div>
							</div>

						</v-col>
						
						<v-col cols="12" md="6" lg="6" xl="6" class="me-auto mt-8">
						
							<p class="font-weight-bold text-h6 text-uppercase">ИНТЕРЬЕР:</p>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Высота в каюте - 1,45 м.</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Количество спальных мест - 4</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Мягкий салон</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Раскладной столик</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Небольшой камбуз (кухня)</p>
								</div>
							</div>
							
							<div class="d-flex my-2">
								<div class="align-self-center me-3">						
									<p class="text-start fs-5"><i class="fas fa-star" style="color:gold"></i></p>
								</div>
								<div class="align-self-center">
									<p class="text-start fs-5">Биотуалет</p>
								</div>
							</div>
							
						</v-col>
					
					</v-row>
					
				</div>
			</div>

		</v-container>

	</v-container>
	
</template>


<script>

	import {DateTime} from "luxon";

    export default {
	
		data: () => ({
				
		}),
	
		created () {

		},
				
		watch: {
			
		},
	
		computed: {
			
		},
		
		methods: {
					
		},
    }
</script>

<style scoped>

	.word-break {
		word-break: break-word;
	}
	
	.maincontainer {
		min-width: 480px;
	}

	.wrap-text {
		white-space: normal;
	}

	.divider-custom {
		width: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.divider-custom .divider-custom-line {
		width: 100%;
		max-width: 7rem;
		height: 0.25rem;
		background-color: #2c3e50;
		border-radius: 1rem;
		border-color: #2c3e50;
	}
	.divider-custom .divider-custom-line:first-child {
		margin-right: 1rem;
	}
	.divider-custom .divider-custom-line:last-child {
		margin-left: 1rem;
	}
	.divider-custom .divider-custom-icon {
		color: #2c3e50;
		font-size: 2rem;
	}
	.divider-custom.divider-light .divider-custom-line {
		background-color: #fff;
	}
	.divider-custom.divider-light .divider-custom-icon {
		color: #fff;
	}


</style>