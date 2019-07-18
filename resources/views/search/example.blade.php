<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
</head>


<body>


<form class="search-filtr-form" action="/find/" method="post">
    <div class="select-block gender">
        <div class="select-block-inner">
            <span>Я</span>
            <div class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><select
                        name="gender_1"
                        style="margin: 0px; padding: 0px; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0;">
                    <option value="1" selected="">Парень</option>
                    <option value="2">Девушка</option>
                </select>
                <div class="jq-selectbox__select" style="position: relative">
                    <div class="jq-selectbox__select-text">Парень</div>
                    <div class="jq-selectbox__trigger">
                        <div class="jq-selectbox__trigger-arrow"></div>
                    </div>
                </div>
                <div class="jq-selectbox__dropdown" style="position: absolute; display: none;">
                    <ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden">
                        <li class="selected sel" style="">Парень</li>
                        <li style="">Девушка</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="select-block-inner">
            <span>Ищу</span>
            <div class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><select
                        name="gender_2"
                        style="margin: 0px; padding: 0px; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0;">
                    <option value="2" selected="">Девушку</option>
                    <option value="1">Парня</option>
                </select>
                <div class="jq-selectbox__select" style="position: relative">
                    <div class="jq-selectbox__select-text">Девушку</div>
                    <div class="jq-selectbox__trigger">
                        <div class="jq-selectbox__trigger-arrow"></div>
                    </div>
                </div>
                <div class="jq-selectbox__dropdown" style="position: absolute; display: none;">
                    <ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden">
                        <li class="selected sel" style="">Девушку</li>
                        <li style="">Парня</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="select-block area">
        <div class="select-block-inner">
            <span>Из</span>
            <div class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><select
                        name="region"
                        style="margin: 0px; padding: 0px; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0;">
                    <option value="0" selected="">Любой регион</option>
                    <option value="4312">Москва и Московская обл.</option>
                    <option value="4925">Санкт-Петербург и область</option>
                    <option value="4052">Краснодарский край</option>
                    <option value="5080">Свердловская обл.</option>
                    <option value="4800">Ростовская обл.</option>
                    <option value="0" disabled="">······················································</option>
                    <option value="1998532">Адыгея</option>
                    <option value="3160">Алтайский край</option>
                    <option value="3223">Амурская обл.</option>
                    <option value="3251">Архангельская обл.</option>
                    <option value="3282">Астраханская обл.</option>
                    <option value="3296">Башкортостан(Башкирия)</option>
                    <option value="3352">Белгородская обл.</option>
                    <option value="3371">Брянская обл.</option>
                    <option value="3407">Бурятия</option>
                    <option value="3437">Владимирская обл.</option>
                    <option value="3468">Волгоградская обл.</option>
                    <option value="3503">Вологодская обл.</option>
                    <option value="3529">Воронежская обл.</option>
                    <option value="3630">Дагестан</option>
                    <option value="3673">Еврейская обл.</option>
                    <option value="3675">Ивановская обл.</option>
                    <option value="3703">Иркутская обл.</option>
                    <option value="3751">Кабардино-Балкария</option>
                    <option value="3761">Калининградская обл.</option>
                    <option value="3827">Калмыкия</option>
                    <option value="3841">Калужская обл.</option>
                    <option value="3872">Камчатская обл.</option>
                    <option value="3892">Карелия</option>
                    <option value="3921">Кемеровская обл.</option>
                    <option value="3952">Кировская обл.</option>
                    <option value="3994">Коми</option>
                    <option value="4026">Костромская обл.</option>
                    <option value="4105">Красноярский край</option>
                    <option value="4176">Курганская обл.</option>
                    <option value="4198">Курская обл.</option>
                    <option value="4227">Липецкая обл.</option>
                    <option value="4243">Магаданская обл.</option>
                    <option value="4270">Марий Эл</option>
                    <option value="4287">Мордовия</option>
                    <option value="4481">Мурманская обл.</option>
                    <option value="3563">Нижегородская (Горьковская)</option>
                    <option value="4503">Новгородская обл.</option>
                    <option value="4528">Новосибирская обл.</option>
                    <option value="4561">Омская обл.</option>
                    <option value="4593">Оренбургская обл.</option>
                    <option value="4633">Орловская обл.</option>
                    <option value="4657">Пензенская обл.</option>
                    <option value="4689">Пермский край</option>
                    <option value="4734">Приморский край</option>
                    <option value="4773">Псковская обл.</option>
                    <option value="4861">Рязанская обл.</option>
                    <option value="4891">Самарская обл.</option>
                    <option value="4969">Саратовская обл.</option>
                    <option value="5011">Саха (Якутия)</option>
                    <option value="5052">Сахалин</option>
                    <option value="5151">Северная Осетия</option>
                    <option value="5161">Смоленская обл.</option>
                    <option value="5191">Ставропольский край</option>
                    <option value="5225">Тамбовская обл.</option>
                    <option value="5246">Татарстан</option>
                    <option value="3784">Тверская обл.</option>
                    <option value="5291">Томская обл.</option>
                    <option value="5312">Тува (Тувинская Респ.)</option>
                    <option value="5326">Тульская обл.</option>
                    <option value="5356">Тюменская обл. и Ханты-Мансийский АО</option>
                    <option value="5404">Удмуртия</option>
                    <option value="5432">Ульяновская обл.</option>
                    <option value="5473">Хабаровский край</option>
                    <option value="2316497">Хакасия</option>
                    <option value="5507">Челябинская обл.</option>
                    <option value="5543">Чечено-Ингушетия</option>
                    <option value="5555">Читинская обл.</option>
                    <option value="5600">Чувашия</option>
                    <option value="2415585">Чукотский АО</option>
                    <option value="5019394">Ямало-Ненецкий АО</option>
                    <option value="5625">Ярославская обл.</option>
                    <option value="28180484">Карачаево-Черкесская Республика</option>
                    <option value="12312311">Крым</option>
                </select>
                <div class="jq-selectbox__select" style="position: relative">
                    <div class="jq-selectbox__select-text">Любой регион</div>
                    <div class="jq-selectbox__trigger">
                        <div class="jq-selectbox__trigger-arrow"></div>
                    </div>
                </div>
                <div class="jq-selectbox__dropdown" style="position: absolute; display: none;">
                    <ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden">
                        <li class="selected sel" style="">Любой регион</li>
                        <li style="">Москва и Московская обл.</li>
                        <li style="">Санкт-Петербург и область</li>
                        <li style="">Краснодарский край</li>
                        <li style="">Свердловская обл.</li>
                        <li style="">Ростовская обл.</li>
                        <li class="disabled" style="">······················································</li>
                        <li style="">Адыгея</li>
                        <li style="">Алтайский край</li>
                        <li style="">Амурская обл.</li>
                        <li style="">Архангельская обл.</li>
                        <li style="">Астраханская обл.</li>
                        <li style="">Башкортостан(Башкирия)</li>
                        <li style="">Белгородская обл.</li>
                        <li style="">Брянская обл.</li>
                        <li style="">Бурятия</li>
                        <li style="">Владимирская обл.</li>
                        <li style="">Волгоградская обл.</li>
                        <li style="">Вологодская обл.</li>
                        <li style="">Воронежская обл.</li>
                        <li style="">Дагестан</li>
                        <li style="">Еврейская обл.</li>
                        <li style="">Ивановская обл.</li>
                        <li style="">Иркутская обл.</li>
                        <li style="">Кабардино-Балкария</li>
                        <li style="">Калининградская обл.</li>
                        <li style="">Калмыкия</li>
                        <li style="">Калужская обл.</li>
                        <li style="">Камчатская обл.</li>
                        <li style="">Карелия</li>
                        <li style="">Кемеровская обл.</li>
                        <li style="">Кировская обл.</li>
                        <li style="">Коми</li>
                        <li style="">Костромская обл.</li>
                        <li style="">Красноярский край</li>
                        <li style="">Курганская обл.</li>
                        <li style="">Курская обл.</li>
                        <li style="">Липецкая обл.</li>
                        <li style="">Магаданская обл.</li>
                        <li style="">Марий Эл</li>
                        <li style="">Мордовия</li>
                        <li style="">Мурманская обл.</li>
                        <li style="">Нижегородская (Горьковская)</li>
                        <li style="">Новгородская обл.</li>
                        <li style="">Новосибирская обл.</li>
                        <li style="">Омская обл.</li>
                        <li style="">Оренбургская обл.</li>
                        <li style="">Орловская обл.</li>
                        <li style="">Пензенская обл.</li>
                        <li style="">Пермский край</li>
                        <li style="">Приморский край</li>
                        <li style="">Псковская обл.</li>
                        <li style="">Рязанская обл.</li>
                        <li style="">Самарская обл.</li>
                        <li style="">Саратовская обл.</li>
                        <li style="">Саха (Якутия)</li>
                        <li style="">Сахалин</li>
                        <li style="">Северная Осетия</li>
                        <li style="">Смоленская обл.</li>
                        <li style="">Ставропольский край</li>
                        <li style="">Тамбовская обл.</li>
                        <li style="">Татарстан</li>
                        <li style="">Тверская обл.</li>
                        <li style="">Томская обл.</li>
                        <li style="">Тува (Тувинская Респ.)</li>
                        <li style="">Тульская обл.</li>
                        <li style="">Тюменская обл. и Ханты-Мансийский АО</li>
                        <li style="">Удмуртия</li>
                        <li style="">Ульяновская обл.</li>
                        <li style="">Хабаровский край</li>
                        <li style="">Хакасия</li>
                        <li style="">Челябинская обл.</li>
                        <li style="">Чечено-Ингушетия</li>
                        <li style="">Читинская обл.</li>
                        <li style="">Чувашия</li>
                        <li style="">Чукотский АО</li>
                        <li style="">Ямало-Ненецкий АО</li>
                        <li style="">Ярославская обл.</li>
                        <li style="">Карачаево-Черкесская Республика</li>
                        <li style="">Крым</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="select-block-inner">
            <div class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><select
                        name="city"
                        style="margin: 0px; padding: 0px; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0;">
                    <option value="0" selected="">Любой город</option>
                </select>
                <div class="jq-selectbox__select" style="position: relative">
                    <div class="jq-selectbox__select-text">Любой город</div>
                    <div class="jq-selectbox__trigger">
                        <div class="jq-selectbox__trigger-arrow"></div>
                    </div>
                </div>
                <div class="jq-selectbox__dropdown" style="position: absolute; display: none;">
                    <ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden">
                        <li class="selected sel" style="">Любой город</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="select-block age">
        <div class="select-block-inner">
            <span>В возрасте</span>
            <div class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><select
                        name="age_from"
                        style="margin: 0px; padding: 0px; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0;">
                    <option value="18" selected="">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
                    <option value="60">60</option>
                    <option value="61">61</option>
                    <option value="62">62</option>
                    <option value="63">63</option>
                    <option value="64">64</option>
                    <option value="65">65</option>
                </select>
                <div class="jq-selectbox__select" style="position: relative">
                    <div class="jq-selectbox__select-text">18</div>
                    <div class="jq-selectbox__trigger">
                        <div class="jq-selectbox__trigger-arrow"></div>
                    </div>
                </div>
                <div class="jq-selectbox__dropdown" style="position: absolute; display: none;">
                    <ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden">
                        <li class="selected sel" style="">18</li>
                        <li style="">19</li>
                        <li style="">20</li>
                        <li style="">21</li>
                        <li style="">22</li>
                        <li style="">23</li>
                        <li style="">24</li>
                        <li style="">25</li>
                        <li style="">26</li>
                        <li style="">27</li>
                        <li style="">28</li>
                        <li style="">29</li>
                        <li style="">30</li>
                        <li style="">31</li>
                        <li style="">32</li>
                        <li style="">33</li>
                        <li style="">34</li>
                        <li style="">35</li>
                        <li style="">36</li>
                        <li style="">37</li>
                        <li style="">38</li>
                        <li style="">39</li>
                        <li style="">40</li>
                        <li style="">41</li>
                        <li style="">42</li>
                        <li style="">43</li>
                        <li style="">44</li>
                        <li style="">45</li>
                        <li style="">46</li>
                        <li style="">47</li>
                        <li style="">48</li>
                        <li style="">49</li>
                        <li style="">50</li>
                        <li style="">51</li>
                        <li style="">52</li>
                        <li style="">53</li>
                        <li style="">54</li>
                        <li style="">55</li>
                        <li style="">56</li>
                        <li style="">57</li>
                        <li style="">58</li>
                        <li style="">59</li>
                        <li style="">60</li>
                        <li style="">61</li>
                        <li style="">62</li>
                        <li style="">63</li>
                        <li style="">64</li>
                        <li style="">65</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="select-block-inner">
            <div class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><select
                        name="age_to"
                        style="margin: 0px; padding: 0px; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0;">
                    <option value="65" selected="">65</option>
                    <option value="64">64</option>
                    <option value="63">63</option>
                    <option value="62">62</option>
                    <option value="61">61</option>
                    <option value="60">60</option>
                    <option value="59">59</option>
                    <option value="58">58</option>
                    <option value="57">57</option>
                    <option value="56">56</option>
                    <option value="55">55</option>
                    <option value="54">54</option>
                    <option value="53">53</option>
                    <option value="52">52</option>
                    <option value="51">51</option>
                    <option value="50">50</option>
                    <option value="49">49</option>
                    <option value="48">48</option>
                    <option value="47">47</option>
                    <option value="46">46</option>
                    <option value="45">45</option>
                    <option value="44">44</option>
                    <option value="43">43</option>
                    <option value="42">42</option>
                    <option value="41">41</option>
                    <option value="40">40</option>
                    <option value="39">39</option>
                    <option value="38">38</option>
                    <option value="37">37</option>
                    <option value="36">36</option>
                    <option value="35">35</option>
                    <option value="34">34</option>
                    <option value="33">33</option>
                    <option value="32">32</option>
                    <option value="31">31</option>
                    <option value="30">30</option>
                    <option value="29">29</option>
                    <option value="28">28</option>
                    <option value="27">27</option>
                    <option value="26">26</option>
                    <option value="25">25</option>
                    <option value="24">24</option>
                    <option value="23">23</option>
                    <option value="22">22</option>
                    <option value="21">21</option>
                    <option value="20">20</option>
                    <option value="19">19</option>
                    <option value="18">18</option>
                </select>
                <div class="jq-selectbox__select" style="position: relative">
                    <div class="jq-selectbox__select-text">65</div>
                    <div class="jq-selectbox__trigger">
                        <div class="jq-selectbox__trigger-arrow"></div>
                    </div>
                </div>
                <div class="jq-selectbox__dropdown" style="position: absolute; display: none;">
                    <ul style="position: relative; list-style: none; overflow: auto; overflow-x: hidden">
                        <li class="selected sel" style="">65</li>
                        <li style="">64</li>
                        <li style="">63</li>
                        <li style="">62</li>
                        <li style="">61</li>
                        <li style="">60</li>
                        <li style="">59</li>
                        <li style="">58</li>
                        <li style="">57</li>
                        <li style="">56</li>
                        <li style="">55</li>
                        <li style="">54</li>
                        <li style="">53</li>
                        <li style="">52</li>
                        <li style="">51</li>
                        <li style="">50</li>
                        <li style="">49</li>
                        <li style="">48</li>
                        <li style="">47</li>
                        <li style="">46</li>
                        <li style="">45</li>
                        <li style="">44</li>
                        <li style="">43</li>
                        <li style="">42</li>
                        <li style="">41</li>
                        <li style="">40</li>
                        <li style="">39</li>
                        <li style="">38</li>
                        <li style="">37</li>
                        <li style="">36</li>
                        <li style="">35</li>
                        <li style="">34</li>
                        <li style="">33</li>
                        <li style="">32</li>
                        <li style="">31</li>
                        <li style="">30</li>
                        <li style="">29</li>
                        <li style="">28</li>
                        <li style="">27</li>
                        <li style="">26</li>
                        <li style="">25</li>
                        <li style="">24</li>
                        <li style="">23</li>
                        <li style="">22</li>
                        <li style="">21</li>
                        <li style="">20</li>
                        <li style="">19</li>
                        <li style="">18</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="checkbox-block photo">
        <label>
            <div id="fo_checkbox-styler" class="jq-checkbox checked" unselectable="on"
                 style="user-select: none; display: inline-block; position: relative; overflow: hidden;"><input
                        type="checkbox" id="fo_checkbox" checked=""
                        style="position: absolute; z-index: -1; opacity: 0; margin: 0px; padding: 0px;">
                <div class="jq-checkbox__div"></div>
            </div>
            С фоткой</label>
        <input type="hidden" name="foto_only" value="1">
    </div>

    <input type="submit" value="Найти" class="uppercase submit-type-1">
</form>

</body>