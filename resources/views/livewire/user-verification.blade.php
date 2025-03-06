 <div class="frm_row">
     <label>Verified</label>
     <input type="checkbox" name="Verified" wire:model="isVerified" wire:change="verifyUser('{{$userId}}')" {{$isVerified == "Yes" ? 'readonly' : ''}} />
 </div>