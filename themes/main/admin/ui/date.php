<div class="input-row">
    <label class="block text-sm font-medium text-gray-700"><?=$label?>
        <?php if ($tooltip ?? null): ?>
            <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

        <?php endif; ?>
    </label>
    <div class="input-box">

        <div class="absolute inset-y-0 right-4 pl-3 flex items-center text-gray-400 cursor-pointer" data-remove style="z-index: 1;">
            <i class="fa-regular fa-times"></i>
        </div>

        <div data-placeholder="<?=$placeholder?>" class="date-input text-sm" data-date-input>
            <input type="hidden" name="<?=$name?>" value="<?=$value?>">


            <div class="mt-1 relative rounded-md shadow-sm">

                    <span style="position: absolute;
                        left: 11px;
                        top: 50%;
                        width: 20px;
                        text-align: center;
                        transform: translateY(-50%);
                        opacity: 0.5;
                        pointer-events: none;">
<i class="fa-sharp fa-regular fa-clock"></i>
                    </span>

                <input type="text" class="date-input block w-full pr-10 focus:outline-none sm:text-sm rounded-md pl-10" placeholder="<?=$placeholder ?? ''?>" value="<?=$value ?? ''?>"
                    style="pointer-events: none;">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none hidden error-icon" >

                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>


            </div>

            <div class="calendar">
                <div class="header">
                    <div class="prev">
                        &lt;
                    </div>
                    <div class="month">2023. április</div>
                    <div class="next">
                        &gt;
                    </div>
                </div>
                <table class="days">
                    <tbody><tr>
                        <th>H</th>
                        <th>K</th>
                        <th>Sze</th>
                        <th>Cs</th>
                        <th>P</th>
                        <th>Szo</th>
                        <th>V</th>
                    </tr>
                    <tr>
                        <td class="other-month"><span class="day ">27</span></td>
                        <td class="other-month"><span class="day ">28</span></td>
                        <td class="other-month"><span class="day ">29</span></td>
                        <td class="other-month"><span class="day ">30</span></td>
                        <td class="other-month"><span class="day">31</span></td>
                        <td class=""><span class="day">1</span></td>
                        <td><span class="day ">2</span></td>
                    </tr>
                    <tr>
                        <td><span class="day">3</span></td>
                        <td><span class="day ">4</span></td>
                        <td><span class="day">5</span></td>
                        <td><span class="day ">6</span></td>
                        <td><span class="day">7</span></td>
                        <td><span class="day ">8</span></td>
                        <td><span class="day">9</span></td>
                    </tr>
                    <tr>
                        <td><span class="day ">10</span></td>
                        <td><span class="day ">11</span></td>
                        <td class=""><span class="day ">12</span></td>
                        <td class="today"><span class="day">13</span></td>
                        <td><span class="day">14</span></td>
                        <td><span class="day">15</span></td>
                        <td><span class="day">16</span></td>
                    </tr>
                    <tr>
                        <td><span class="day">17</span></td>
                        <td><span class="day">18</span></td>
                        <td class=""><span class="day">19</span></td>
                        <td><span class="day">20</span></td>
                        <td class=""><span class="day">21</span></td>
                        <td><span class="day">22</span></td>
                        <td><span class="day">23</span></td>
                    </tr>
                    <tr>
                        <td><span class="day">24</span></td>
                        <td><span class="day">25</span></td>
                        <td><span class="day">26</span></td>
                        <td class=""><span class="day">27</span></td>
                        <td class=""><span class="day">28</span></td>
                        <td class=""><span class="day">29</span></td>
                        <td class=""><span class="day">30</span></td>
                    </tr>
                    <tr>
                        <td class="other-month"><span class="day">1</span></td>
                        <td class="other-month"><span class="day">2</span></td>
                        <td class="other-month"><span class="day">3</span></td>
                        <td class="other-month"><span class="day">4</span></td>
                        <td class="other-month"><span class="day">5</span></td>
                        <td class="other-month"><span class="day">6</span></td>
                        <td class="other-month"><span class="day">7</span></td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
</div>
</div>