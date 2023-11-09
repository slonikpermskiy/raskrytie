<template>

	<v-list-item-content class="py-0" v-bind:class="padding">
		
		<v-list-item-title class="wrap-text" v-bind:class="textsize">
																							
			<span v-if="value.freq==1">
				<span>Однократно</span><!--
				--><span v-if="value.onetimeday!='' & value.onetimeday!=null">, </span><!--
				--><span v-if="value.onetimeday!='' & value.onetimeday!=null">{{ formatDate(value.onetimeday)}}</span><!--
				--><span v-if="value.comment!='' & value.comment!=null">, </span><!--			
				--><span v-if="value.comment!='' & value.comment!=null">{{ value.comment }}</span>												
			</span>
			
			<span v-if="value.freq==2">															
				<span>{{ intervdayitems.find(o => o.id === value.intervday).value }}</span><!--
				--><span v-if="value.comment!='' & value.comment!=null">, </span><!--			
				--><span v-if="value.comment!='' & value.comment!=null">{{ value.comment }}</span>
			</span>
			
			<span v-if="value.freq==3">															
				<span>{{ intervweekitems.find(o => o.id === value.intervweek).value+',' }}</span>
				<span>{{ weekdaysitems.find(o => o.id === value.weekdays).value  }}</span><!--
				--><span v-if="value.comment!='' & value.comment!=null">, </span><!--			
				--><span v-if="value.comment!='' & value.comment!=null">{{ value.comment }}</span>
			</span>
			
			<span v-if="value.freq==4">															
				<span>{{ intervmonthitems.find(o => o.id === value.intervmonth).value+',' }}</span>
				<span v-if="value.monthmethod==1">{{ defaultmonthdays.find(o => o.id === value.monthdays).value+' день' }}</span><!--
				--><span v-if="value.monthmethod==2">{{ monthweekitems.find(o => o.id === value.monthweek).value+' неделя, ' }}</span><!--
				--><span v-if="value.monthmethod==2">{{ weekdaysitems.find(o => o.id === value.monthweekdays).value }}</span><!--
				--><span v-if="value.comment!='' & value.comment!=null">, </span><!--			
				--><span v-if="value.comment!='' & value.comment!=null">{{ value.comment }}</span>														
			</span>
			
			<span v-if="value.freq==5">															
				<span>{{ intervquarteritems.find(o => o.id === value.intervquarter).value+',' }}</span>
				<span>{{ quarterdays.find(o => o.id === value.quarterdays).value+' день' }}</span><!--
				--><span v-if="value.comment!='' & value.comment!=null">, </span><!--			
				--><span v-if="value.comment!='' & value.comment!=null">{{ value.comment }}</span>																			
			</span>
			
			<span v-if="value.freq==6">															
				<span>{{ intervyearitems.find(o => o.id === value.intervyear).value+',' }}</span>
				<span>{{ yearmonthitems.find(o => o.id === value.yearmonth).value+',' }}</span>
				<span v-if="value.yearmethod==1">{{ defaultmonthdays.find(o => o.id === value.yearmonthdays).value+' день' }}</span><!--
														
				--><span v-if="value.yearmethod==2">{{ monthweekitems.find(o => o.id === value.yearmonthweek).value+' неделя, ' }}</span><!--
				--><span v-if="value.yearmethod==2">{{ weekdaysitems.find(o => o.id === value.yearmonthweekdays).value }}</span><!--
				
				--><span v-if="value.comment!='' & value.comment!=null">, </span><!--			
				--><span v-if="value.comment!='' & value.comment!=null">{{ value.comment }}</span>														
			</span>								
			
		</v-list-item-title>								
	</v-list-item-content>

</template>

<script>

	import {DateTime} from "luxon";

	export default {
		
		name: "OtchetPeriods",
				
		data: () => ({
			
		}),
		
		props: {
			value: Object,
			intervdayitems: Array,
		  	intervweekitems: Array,
			weekdaysitems: Array,
			intervmonthitems: Array,
			defaultmonthdays: Array,
			monthweekitems: Array,
			intervquarteritems: Array,
			quarterdays: Array,
			intervyearitems: Array,
			yearmonthitems: Array,
			'textsize': String,
			'padding': String,
		},
		
		
		methods: {
		
			formatDate(date) {
				if (date === null || date === undefined) {
					return null
				} else {
					return DateTime.fromISO(date).toFormat('dd.MM.yyyy');
				}
			},
				
		},

	}

</script>