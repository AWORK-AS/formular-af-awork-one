<?php
   $opts = cfa_get_settings();
   $token = $opts[CFA_TEXTDOMAIN . '_token'] ?? false;
?>
<?php if($token): ?>
     <div class="cfa-icon-box">
        <div class="cfa-icon cfa-connected">
            <svg viewBox="0 0 100 100" width="60" height="60">
                <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8"/>
                <path d="M30,50 Q50,30 70,50" fill="none" stroke="currentColor" stroke-width="5"/>
                <path d="M30,50 Q50,70 70,50" fill="none" stroke="currentColor" stroke-width="5"/>
                <circle cx="30" cy="50" r="8" fill="currentColor"/>
                <circle cx="70" cy="50" r="8" fill="currentColor"/>
            </svg>
        </div>
     </div>
<?php else:?>
    <div class="cfa-icon-box">
        <div class="cfa-icon cfa-not-connected">
            <svg viewBox="0 0 100 100" width="60" height="60">
                <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8"/>
                <path d="M30,30 L70,70" stroke="currentColor" stroke-width="5"/>
                <path d="M70,30 L30,70" stroke="currentColor" stroke-width="5"/>
                <circle cx="30" cy="30" r="8" fill="currentColor"/>
                <circle cx="70" cy="70" r="8" fill="currentColor"/>
            </svg>
        </div>
    </div>
<?php endif;?>