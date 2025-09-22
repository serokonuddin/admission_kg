@if($type=='primary' || $type==1)
<option value="">Select Time</option>
<option value="07:30 AM-08:10 AM">07:30 AM-08:10 AM</option>
<option value="08:10 AM-08:50 AM">08:10 AM-08:50 AM</option>
<option value="08:50 AM-09:30 AM">08:50 AM-09:30 AM</option>
<option value="08:50 AM-09:20 AM">08:50 AM-09:20 AM Tiffin</option>
<option value="09:20 AM-10:00 AM">09:20 AM-10:00 AM</option>
<option value="09:30 AM-10:00 AM">09:30 AM-10:00 AM Tiffin</option>
<option value="10:00 AM-10:40 AM">10:00 AM-10:40 AM</option>
<option value="10:40 AM-11:20 AM">10:40 AM-11:20 AM</option>

<option value="12:30 PM-01:10 PM">12:30 PM-01:10 PM</option>
<option value="01:10 PM-01:50 PM">01:10 PM-01:50 PM</option>
<option value="01:50 PM-02:30 PM">01:50 PM-02:30 PM</option>
<option value="02:30 PM-03:00 PM">02:30 PM-03:00 PM Tiffin</option>
<option value="03:00 PM-03:40 PM">03:00 PM-03:40 PM</option>
<option value="03:40 PM-04:20 PM">03:40 PM-04:20 PM </option>
                        
@elseif($type=='secondary' || $type==2)
<option value="">Select Time</option>
<option value="07:30 AM-08:10 AM">07:30 AM-08:10 AM</option>
<option value="08:10 AM-08:50 AM">08:10 AM-08:50 AM</option>
<option value="08:50 AM-09:30 AM">08:50 AM-09:30 AM</option>
<option value="09:30 AM-09:50 AM">09:30 AM-09:50 AM</option>
<option value="09:50 AM-10:30 AM">09:50 AM-10:30 AM</option>
<option value="10:30 AM-11:00 AM">10:30 AM-11:00 AM</option>
<option value="11:00 AM-11:30 AM">11:00 AM-11:30 AM</option>

<option value="12:30 PM-01:10 PM">12:30 PM-01:10 PM</option>
<option value="01:10 PM-01:50 PM">01:10 PM-01:50 PM</option>
<option value="01:50 PM-02:30 PM">01:50 PM-02:30 PM</option>
<option value="02:30 PM-03:00 PM">02:30 PM-03:00 PM Tiffin</option>
<option value="03:00 PM-03:40 PM">03:00 PM-03:40 PM</option>
<option value="03:40 PM-04:10 PM">03:40 PM-04:10 PM </option>
<option value="04:10 PM-04:40 PM">04:10 PM-04:40 PM </option>
@else
<option value="">Select Time</option>
<option value="08:15 AM-08:30 AM">08:15 AM-08:30 AM</option>
<option value="08:30 AM-09:10 AM">08:30 AM-09:10 AM</option>
<option value="09:10 AM-09:50 AM">09:10 AM-09:50 AM</option>
<option value="09:50 AM-10:30 AM">09:50 AM-10:30 AM</option>
<option value="10:30 AM-11:10 AM">10:30 AM-11:10 AM</option>
<option value="11:10 AM-11:50 AM">11:10 AM-11:50 AM</option>
<option value="11:50 AM-12:30 PM">11:50 AM-12:30 PM</option>
<option value="12:30 PM-01:10 PM">12:30 PM-01:10 PM</option>
<option value="01:10 PM-01:50 PM">01:10 PM-01:50 PM</option>
@endif