<?php global $mySessionFront;?>

<!--============================================ Java Script & Css ===========================================-->	
<script src="<?=JS_URL?>jquery-1.5.js" type="text/javascript"></script>
<script language = "Javascript">
	//$(document).ready(function() {
         // $('body').addClass('home');
        //});
		
	$(document).ready(function() {
        $('li').removeClass('active');
        });	
		

</script>

<!--============================================ End Java Script & Css ===========================================-->  


<div class="container register_page recruiter_page">
<!--================================================ Error Message ===========================================-->
<div id="divError">
	<?php if(isset($mySession->errorMsg)){ ?>
    <div id="message-red">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td class="red-left">
        <?php echo $mySession->errorMsg; ?>
        </td>
		<td class="red-right">
        <a onclick="Javascript:document.getElementById('divError').style.display='none';">
        	<img src="<?=IMAGES_URL?>icon_close_red.gif" alt="">
        </a>
        </td>
	</tr>
	</tbody></table>
	</div>
    <?php unset($mySession->errorMsg);} ?>
    
    <?php if(isset($mySession->sucMsg)){ ?>
    <div id="message-green">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody><tr>
		<td class="green-left">
        	<?php echo $mySession->sucMsg; ?>
        </td>
		<td class="green-right">
        <a onclick="Javascript:document.getElementById('divError').style.display='none';" class="close-green">
        	<img alt="" src="<?=IMAGES_URL?>icon_close_green.gif">
        </a>
        </td>
	</tr>
	</tbody></table>
	</div>
    <?php unset($mySession->sucMsg); } ?>
    
    <?php if(isset($mySession->warningMsg)){ ?>
    <div id="message-red">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td class="red-left">
        <?php echo $mySession->warningMsg; ?>
        </td>
		<td class="red-right">
        <a onclick="Javascript:document.getElementById('divError').style.display='none';">
        	<img src="<?=IMAGES_URL?>icon_close_red.gif" alt="">
        </a>
        </td>
	</tr>
	</tbody></table>
	</div>
    <?php unset($mySession->warningMsg); } ?>
</div>
<!--============================================ end Error Message ===========================================-->
<?php if($_REQUEST['user_type']=='Employer') { 

//	if(is_array($ComtDetail) && count($ComtDetail) > 0) 
	?>
<h1 class="title">Join over 40,000 employers who trust JOBPORTAL.com as their career partner</h1>
            <div class="floatleft highlight-box1">
            	<h3>Why Choose jobportal .com?</h3>
                <ul class="check_icons">
                	<li>Access to 12,250,000 qualified job seekers, anytime.</li>
                    <li>5 million visits/month, giving your jobs top visibility.</li>
                    <li>Friendly, on-the-ground support from our 12 regional offices.</li>
                    <li>We speak Arabic, English, French.</li>
                    <li>Solutions for all budgets, some even for free!</li>
                </ul>
            </div>
            <div class="floatright highlight-box1">
            	<h3>Contact Options</h3>
                <ul class="icon_list">
                	<li><img alt="" src="images/phone_icon.png"><br>+123.4.1234567</li>
                    <li><img alt="" src="images/mail_icon.png"><br><a href="#">Email us</a></li>
                </ul>
            </div>
            <div class="clr"></div>
            <div class="seperator">&nbsp;</div>
            <h2 class="title">Register Using Your Email (it will only take a minute!)<span class="floatright orng">* Required Fields</span>.</h2>
            <div class="form selectForm jqtransformdone">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody><tr>
                    <td>FIRST NAME <span class="red">*</span><br><input type="text" class="inputbox" value=""></td>
                    <td>LAST NAME <span class="red">*</span><br><input type="text" class="inputbox" value=""></td>
                    <td>EMAIL <span class="red">*</span><br><input type="text" class="inputbox" value=""></td>
                  </tr>
                  <tr>
                    <td>COUNTRY <span class="red">*</span><br><div class="jqTransformSelectWrapper" style="z-index: 10; width: 424px;"><div><span style="width: 393px;">Select Country</span><a class="jqTransformSelectOpen" href="#"></a></div><ul style="width: 422px; display: none; visibility: visible;"><li><a index="0" href="#" class="selected">Select Country</a></li><li><a index="1" href="#">United States</a></li><li><a index="2" href="#">United Kingdom</a></li><li><a index="3" href="#">Afghanistan</a></li><li><a index="4" href="#">Albania</a></li><li><a index="5" href="#">Algeria</a></li><li><a index="6" href="#">American Samoa</a></li><li><a index="7" href="#">Andorra</a></li><li><a index="8" href="#">Angola</a></li><li><a index="9" href="#">Anguilla</a></li><li><a index="10" href="#">Antarctica</a></li><li><a index="11" href="#">Antigua and Barbuda</a></li><li><a index="12" href="#">Argentina</a></li><li><a index="13" href="#">Armenia</a></li><li><a index="14" href="#">Aruba</a></li><li><a index="15" href="#">Australia</a></li><li><a index="16" href="#">Austria</a></li><li><a index="17" href="#">Azerbaijan</a></li><li><a index="18" href="#">Bahamas</a></li><li><a index="19" href="#">Bahrain</a></li><li><a index="20" href="#">Bangladesh</a></li><li><a index="21" href="#">Barbados</a></li><li><a index="22" href="#">Belarus</a></li><li><a index="23" href="#">Belgium</a></li><li><a index="24" href="#">Belize</a></li><li><a index="25" href="#">Benin</a></li><li><a index="26" href="#">Bermuda</a></li><li><a index="27" href="#">Bhutan</a></li><li><a index="28" href="#">Bolivia</a></li><li><a index="29" href="#">Bosnia and Herzegovina</a></li><li><a index="30" href="#">Botswana</a></li><li><a index="31" href="#">Bouvet Island</a></li><li><a index="32" href="#">Brazil</a></li><li><a index="33" href="#">British Indian Ocean Territory</a></li><li><a index="34" href="#">Brunei Darussalam</a></li><li><a index="35" href="#">Bulgaria</a></li><li><a index="36" href="#">Burkina Faso</a></li><li><a index="37" href="#">Burundi</a></li><li><a index="38" href="#">Cambodia</a></li><li><a index="39" href="#">Cameroon</a></li><li><a index="40" href="#">Canada</a></li><li><a index="41" href="#">Cape Verde</a></li><li><a index="42" href="#">Cayman Islands</a></li><li><a index="43" href="#">Central African Republic</a></li><li><a index="44" href="#">Chad</a></li><li><a index="45" href="#">Chile</a></li><li><a index="46" href="#">China</a></li><li><a index="47" href="#">Christmas Island</a></li><li><a index="48" href="#">Cocos (Keeling) Islands</a></li><li><a index="49" href="#">Colombia</a></li><li><a index="50" href="#">Comoros</a></li><li><a index="51" href="#">Congo</a></li><li><a index="52" href="#">Congo, The Democratic Republic of The</a></li><li><a index="53" href="#">Cook Islands</a></li><li><a index="54" href="#">Costa Rica</a></li><li><a index="55" href="#">Cote D'ivoire</a></li><li><a index="56" href="#">Croatia</a></li><li><a index="57" href="#">Cuba</a></li><li><a index="58" href="#">Cyprus</a></li><li><a index="59" href="#">Czech Republic</a></li><li><a index="60" href="#">Denmark</a></li><li><a index="61" href="#">Djibouti</a></li><li><a index="62" href="#">Dominica</a></li><li><a index="63" href="#">Dominican Republic</a></li><li><a index="64" href="#">Ecuador</a></li><li><a index="65" href="#">Egypt</a></li><li><a index="66" href="#">El Salvador</a></li><li><a index="67" href="#">Equatorial Guinea</a></li><li><a index="68" href="#">Eritrea</a></li><li><a index="69" href="#">Estonia</a></li><li><a index="70" href="#">Ethiopia</a></li><li><a index="71" href="#">Falkland Islands (Malvinas)</a></li><li><a index="72" href="#">Faroe Islands</a></li><li><a index="73" href="#">Fiji</a></li><li><a index="74" href="#">Finland</a></li><li><a index="75" href="#">France</a></li><li><a index="76" href="#">French Guiana</a></li><li><a index="77" href="#">French Polynesia</a></li><li><a index="78" href="#">French Southern Territories</a></li><li><a index="79" href="#">Gabon</a></li><li><a index="80" href="#">Gambia</a></li><li><a index="81" href="#">Georgia</a></li><li><a index="82" href="#">Germany</a></li><li><a index="83" href="#">Ghana</a></li><li><a index="84" href="#">Gibraltar</a></li><li><a index="85" href="#">Greece</a></li><li><a index="86" href="#">Greenland</a></li><li><a index="87" href="#">Grenada</a></li><li><a index="88" href="#">Guadeloupe</a></li><li><a index="89" href="#">Guam</a></li><li><a index="90" href="#">Guatemala</a></li><li><a index="91" href="#">Guinea</a></li><li><a index="92" href="#">Guinea-bissau</a></li><li><a index="93" href="#">Guyana</a></li><li><a index="94" href="#">Haiti</a></li><li><a index="95" href="#">Heard Island and Mcdonald Islands</a></li><li><a index="96" href="#">Holy See (Vatican City State)</a></li><li><a index="97" href="#">Honduras</a></li><li><a index="98" href="#">Hong Kong</a></li><li><a index="99" href="#">Hungary</a></li><li><a index="100" href="#">Iceland</a></li><li><a index="101" href="#">India</a></li><li><a index="102" href="#">Indonesia</a></li><li><a index="103" href="#">Iran, Islamic Republic of</a></li><li><a index="104" href="#">Iraq</a></li><li><a index="105" href="#">Ireland</a></li><li><a index="106" href="#">Israel</a></li><li><a index="107" href="#">Italy</a></li><li><a index="108" href="#">Jamaica</a></li><li><a index="109" href="#">Japan</a></li><li><a index="110" href="#">Jordan</a></li><li><a index="111" href="#">Kazakhstan</a></li><li><a index="112" href="#">Kenya</a></li><li><a index="113" href="#">Kiribati</a></li><li><a index="114" href="#">Korea, Democratic People's Republic of</a></li><li><a index="115" href="#">Korea, Republic of</a></li><li><a index="116" href="#">Kuwait</a></li><li><a index="117" href="#">Kyrgyzstan</a></li><li><a index="118" href="#">Lao People's Democratic Republic</a></li><li><a index="119" href="#">Latvia</a></li><li><a index="120" href="#">Lebanon</a></li><li><a index="121" href="#">Lesotho</a></li><li><a index="122" href="#">Liberia</a></li><li><a index="123" href="#">Libyan Arab Jamahiriya</a></li><li><a index="124" href="#">Liechtenstein</a></li><li><a index="125" href="#">Lithuania</a></li><li><a index="126" href="#">Luxembourg</a></li><li><a index="127" href="#">Macao</a></li><li><a index="128" href="#">Macedonia, The Former Yugoslav Republic of</a></li><li><a index="129" href="#">Madagascar</a></li><li><a index="130" href="#">Malawi</a></li><li><a index="131" href="#">Malaysia</a></li><li><a index="132" href="#">Maldives</a></li><li><a index="133" href="#">Mali</a></li><li><a index="134" href="#">Malta</a></li><li><a index="135" href="#">Marshall Islands</a></li><li><a index="136" href="#">Martinique</a></li><li><a index="137" href="#">Mauritania</a></li><li><a index="138" href="#">Mauritius</a></li><li><a index="139" href="#">Mayotte</a></li><li><a index="140" href="#">Mexico</a></li><li><a index="141" href="#">Micronesia, Federated States of</a></li><li><a index="142" href="#">Moldova, Republic of</a></li><li><a index="143" href="#">Monaco</a></li><li><a index="144" href="#">Mongolia</a></li><li><a index="145" href="#">Montserrat</a></li><li><a index="146" href="#">Morocco</a></li><li><a index="147" href="#">Mozambique</a></li><li><a index="148" href="#">Myanmar</a></li><li><a index="149" href="#">Namibia</a></li><li><a index="150" href="#">Nauru</a></li><li><a index="151" href="#">Nepal</a></li><li><a index="152" href="#">Netherlands</a></li><li><a index="153" href="#">Netherlands Antilles</a></li><li><a index="154" href="#">New Caledonia</a></li><li><a index="155" href="#">New Zealand</a></li><li><a index="156" href="#">Nicaragua</a></li><li><a index="157" href="#">Niger</a></li><li><a index="158" href="#">Nigeria</a></li><li><a index="159" href="#">Niue</a></li><li><a index="160" href="#">Norfolk Island</a></li><li><a index="161" href="#">Northern Mariana Islands</a></li><li><a index="162" href="#">Norway</a></li><li><a index="163" href="#">Oman</a></li><li><a index="164" href="#">Pakistan</a></li><li><a index="165" href="#">Palau</a></li><li><a index="166" href="#">Palestinian Territory, Occupied</a></li><li><a index="167" href="#">Panama</a></li><li><a index="168" href="#">Papua New Guinea</a></li><li><a index="169" href="#">Paraguay</a></li><li><a index="170" href="#">Peru</a></li><li><a index="171" href="#">Philippines</a></li><li><a index="172" href="#">Pitcairn</a></li><li><a index="173" href="#">Poland</a></li><li><a index="174" href="#">Portugal</a></li><li><a index="175" href="#">Puerto Rico</a></li><li><a index="176" href="#">Qatar</a></li><li><a index="177" href="#">Reunion</a></li><li><a index="178" href="#">Romania</a></li><li><a index="179" href="#">Russian Federation</a></li><li><a index="180" href="#">Rwanda</a></li><li><a index="181" href="#">Saint Helena</a></li><li><a index="182" href="#">Saint Kitts and Nevis</a></li><li><a index="183" href="#">Saint Lucia</a></li><li><a index="184" href="#">Saint Pierre and Miquelon</a></li><li><a index="185" href="#">Saint Vincent and The Grenadines</a></li><li><a index="186" href="#">Samoa</a></li><li><a index="187" href="#">San Marino</a></li><li><a index="188" href="#">Sao Tome and Principe</a></li><li><a index="189" href="#">Saudi Arabia</a></li><li><a index="190" href="#">Senegal</a></li><li><a index="191" href="#">Serbia and Montenegro</a></li><li><a index="192" href="#">Seychelles</a></li><li><a index="193" href="#">Sierra Leone</a></li><li><a index="194" href="#">Singapore</a></li><li><a index="195" href="#">Slovakia</a></li><li><a index="196" href="#">Slovenia</a></li><li><a index="197" href="#">Solomon Islands</a></li><li><a index="198" href="#">Somalia</a></li><li><a index="199" href="#">South Africa</a></li><li><a index="200" href="#">South Georgia and The South Sandwich Islands</a></li><li><a index="201" href="#">Spain</a></li><li><a index="202" href="#">Sri Lanka</a></li><li><a index="203" href="#">Sudan</a></li><li><a index="204" href="#">Suriname</a></li><li><a index="205" href="#">Svalbard and Jan Mayen</a></li><li><a index="206" href="#">Swaziland</a></li><li><a index="207" href="#">Sweden</a></li><li><a index="208" href="#">Switzerland</a></li><li><a index="209" href="#">Syrian Arab Republic</a></li><li><a index="210" href="#">Taiwan, Province of China</a></li><li><a index="211" href="#">Tajikistan</a></li><li><a index="212" href="#">Tanzania, United Republic of</a></li><li><a index="213" href="#">Thailand</a></li><li><a index="214" href="#">Timor-leste</a></li><li><a index="215" href="#">Togo</a></li><li><a index="216" href="#">Tokelau</a></li><li><a index="217" href="#">Tonga</a></li><li><a index="218" href="#">Trinidad and Tobago</a></li><li><a index="219" href="#">Tunisia</a></li><li><a index="220" href="#">Turkey</a></li><li><a index="221" href="#">Turkmenistan</a></li><li><a index="222" href="#">Turks and Caicos Islands</a></li><li><a index="223" href="#">Tuvalu</a></li><li><a index="224" href="#">Uganda</a></li><li><a index="225" href="#">Ukraine</a></li><li><a index="226" href="#">United Arab Emirates</a></li><li><a index="227" href="#">United Kingdom</a></li><li><a index="228" href="#">United States</a></li><li><a index="229" href="#">United States Minor Outlying Islands</a></li><li><a index="230" href="#">Uruguay</a></li><li><a index="231" href="#">Uzbekistan</a></li><li><a index="232" href="#">Vanuatu</a></li><li><a index="233" href="#">Venezuela</a></li><li><a index="234" href="#">Viet Nam</a></li><li><a index="235" href="#">Virgin Islands, British</a></li><li><a index="236" href="#">Virgin Islands, U.S.</a></li><li><a index="237" href="#">Wallis and Futuna</a></li><li><a index="238" href="#">Western Sahara</a></li><li><a index="239" href="#">Yemen</a></li><li><a index="240" href="#">Zambia</a></li><li><a index="241" href="#">Zimbabwe</a></li></ul><select name="Country" class="jqTransformHidden" style=""> 
<option selected="selected" value="">Select Country</option> 
<option value="United States">United States</option> 
<option value="United Kingdom">United Kingdom</option> 
<option value="Afghanistan">Afghanistan</option> 
<option value="Albania">Albania</option> 
<option value="Algeria">Algeria</option> 
<option value="American Samoa">American Samoa</option> 
<option value="Andorra">Andorra</option> 
<option value="Angola">Angola</option> 
<option value="Anguilla">Anguilla</option> 
<option value="Antarctica">Antarctica</option> 
<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
<option value="Argentina">Argentina</option> 
<option value="Armenia">Armenia</option> 
<option value="Aruba">Aruba</option> 
<option value="Australia">Australia</option> 
<option value="Austria">Austria</option> 
<option value="Azerbaijan">Azerbaijan</option> 
<option value="Bahamas">Bahamas</option> 
<option value="Bahrain">Bahrain</option> 
<option value="Bangladesh">Bangladesh</option> 
<option value="Barbados">Barbados</option> 
<option value="Belarus">Belarus</option> 
<option value="Belgium">Belgium</option> 
<option value="Belize">Belize</option> 
<option value="Benin">Benin</option> 
<option value="Bermuda">Bermuda</option> 
<option value="Bhutan">Bhutan</option> 
<option value="Bolivia">Bolivia</option> 
<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
<option value="Botswana">Botswana</option> 
<option value="Bouvet Island">Bouvet Island</option> 
<option value="Brazil">Brazil</option> 
<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
<option value="Brunei Darussalam">Brunei Darussalam</option> 
<option value="Bulgaria">Bulgaria</option> 
<option value="Burkina Faso">Burkina Faso</option> 
<option value="Burundi">Burundi</option> 
<option value="Cambodia">Cambodia</option> 
<option value="Cameroon">Cameroon</option> 
<option value="Canada">Canada</option> 
<option value="Cape Verde">Cape Verde</option> 
<option value="Cayman Islands">Cayman Islands</option> 
<option value="Central African Republic">Central African Republic</option> 
<option value="Chad">Chad</option> 
<option value="Chile">Chile</option> 
<option value="China">China</option> 
<option value="Christmas Island">Christmas Island</option> 
<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
<option value="Colombia">Colombia</option> 
<option value="Comoros">Comoros</option> 
<option value="Congo">Congo</option> 
<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
<option value="Cook Islands">Cook Islands</option> 
<option value="Costa Rica">Costa Rica</option> 
<option value="Cote D'ivoire">Cote D'ivoire</option> 
<option value="Croatia">Croatia</option> 
<option value="Cuba">Cuba</option> 
<option value="Cyprus">Cyprus</option> 
<option value="Czech Republic">Czech Republic</option> 
<option value="Denmark">Denmark</option> 
<option value="Djibouti">Djibouti</option> 
<option value="Dominica">Dominica</option> 
<option value="Dominican Republic">Dominican Republic</option> 
<option value="Ecuador">Ecuador</option> 
<option value="Egypt">Egypt</option> 
<option value="El Salvador">El Salvador</option> 
<option value="Equatorial Guinea">Equatorial Guinea</option> 
<option value="Eritrea">Eritrea</option> 
<option value="Estonia">Estonia</option> 
<option value="Ethiopia">Ethiopia</option> 
<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
<option value="Faroe Islands">Faroe Islands</option> 
<option value="Fiji">Fiji</option> 
<option value="Finland">Finland</option> 
<option value="France">France</option> 
<option value="French Guiana">French Guiana</option> 
<option value="French Polynesia">French Polynesia</option> 
<option value="French Southern Territories">French Southern Territories</option> 
<option value="Gabon">Gabon</option> 
<option value="Gambia">Gambia</option> 
<option value="Georgia">Georgia</option> 
<option value="Germany">Germany</option> 
<option value="Ghana">Ghana</option> 
<option value="Gibraltar">Gibraltar</option> 
<option value="Greece">Greece</option> 
<option value="Greenland">Greenland</option> 
<option value="Grenada">Grenada</option> 
<option value="Guadeloupe">Guadeloupe</option> 
<option value="Guam">Guam</option> 
<option value="Guatemala">Guatemala</option> 
<option value="Guinea">Guinea</option> 
<option value="Guinea-bissau">Guinea-bissau</option> 
<option value="Guyana">Guyana</option> 
<option value="Haiti">Haiti</option> 
<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
<option value="Honduras">Honduras</option> 
<option value="Hong Kong">Hong Kong</option> 
<option value="Hungary">Hungary</option> 
<option value="Iceland">Iceland</option> 
<option value="India">India</option> 
<option value="Indonesia">Indonesia</option> 
<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
<option value="Iraq">Iraq</option> 
<option value="Ireland">Ireland</option> 
<option value="Israel">Israel</option> 
<option value="Italy">Italy</option> 
<option value="Jamaica">Jamaica</option> 
<option value="Japan">Japan</option> 
<option value="Jordan">Jordan</option> 
<option value="Kazakhstan">Kazakhstan</option> 
<option value="Kenya">Kenya</option> 
<option value="Kiribati">Kiribati</option> 
<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
<option value="Korea, Republic of">Korea, Republic of</option> 
<option value="Kuwait">Kuwait</option> 
<option value="Kyrgyzstan">Kyrgyzstan</option> 
<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
<option value="Latvia">Latvia</option> 
<option value="Lebanon">Lebanon</option> 
<option value="Lesotho">Lesotho</option> 
<option value="Liberia">Liberia</option> 
<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
<option value="Liechtenstein">Liechtenstein</option> 
<option value="Lithuania">Lithuania</option> 
<option value="Luxembourg">Luxembourg</option> 
<option value="Macao">Macao</option> 
<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
<option value="Madagascar">Madagascar</option> 
<option value="Malawi">Malawi</option> 
<option value="Malaysia">Malaysia</option> 
<option value="Maldives">Maldives</option> 
<option value="Mali">Mali</option> 
<option value="Malta">Malta</option> 
<option value="Marshall Islands">Marshall Islands</option> 
<option value="Martinique">Martinique</option> 
<option value="Mauritania">Mauritania</option> 
<option value="Mauritius">Mauritius</option> 
<option value="Mayotte">Mayotte</option> 
<option value="Mexico">Mexico</option> 
<option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
<option value="Moldova, Republic of">Moldova, Republic of</option> 
<option value="Monaco">Monaco</option> 
<option value="Mongolia">Mongolia</option> 
<option value="Montserrat">Montserrat</option> 
<option value="Morocco">Morocco</option> 
<option value="Mozambique">Mozambique</option> 
<option value="Myanmar">Myanmar</option> 
<option value="Namibia">Namibia</option> 
<option value="Nauru">Nauru</option> 
<option value="Nepal">Nepal</option> 
<option value="Netherlands">Netherlands</option> 
<option value="Netherlands Antilles">Netherlands Antilles</option> 
<option value="New Caledonia">New Caledonia</option> 
<option value="New Zealand">New Zealand</option> 
<option value="Nicaragua">Nicaragua</option> 
<option value="Niger">Niger</option> 
<option value="Nigeria">Nigeria</option> 
<option value="Niue">Niue</option> 
<option value="Norfolk Island">Norfolk Island</option> 
<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
<option value="Norway">Norway</option> 
<option value="Oman">Oman</option> 
<option value="Pakistan">Pakistan</option> 
<option value="Palau">Palau</option> 
<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
<option value="Panama">Panama</option> 
<option value="Papua New Guinea">Papua New Guinea</option> 
<option value="Paraguay">Paraguay</option> 
<option value="Peru">Peru</option> 
<option value="Philippines">Philippines</option> 
<option value="Pitcairn">Pitcairn</option> 
<option value="Poland">Poland</option> 
<option value="Portugal">Portugal</option> 
<option value="Puerto Rico">Puerto Rico</option> 
<option value="Qatar">Qatar</option> 
<option value="Reunion">Reunion</option> 
<option value="Romania">Romania</option> 
<option value="Russian Federation">Russian Federation</option> 
<option value="Rwanda">Rwanda</option> 
<option value="Saint Helena">Saint Helena</option> 
<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
<option value="Saint Lucia">Saint Lucia</option> 
<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
<option value="Samoa">Samoa</option> 
<option value="San Marino">San Marino</option> 
<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
<option value="Saudi Arabia">Saudi Arabia</option> 
<option value="Senegal">Senegal</option> 
<option value="Serbia and Montenegro">Serbia and Montenegro</option> 
<option value="Seychelles">Seychelles</option> 
<option value="Sierra Leone">Sierra Leone</option> 
<option value="Singapore">Singapore</option> 
<option value="Slovakia">Slovakia</option> 
<option value="Slovenia">Slovenia</option> 
<option value="Solomon Islands">Solomon Islands</option> 
<option value="Somalia">Somalia</option> 
<option value="South Africa">South Africa</option> 
<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
<option value="Spain">Spain</option> 
<option value="Sri Lanka">Sri Lanka</option> 
<option value="Sudan">Sudan</option> 
<option value="Suriname">Suriname</option> 
<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
<option value="Swaziland">Swaziland</option> 
<option value="Sweden">Sweden</option> 
<option value="Switzerland">Switzerland</option> 
<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
<option value="Taiwan, Province of China">Taiwan, Province of China</option> 
<option value="Tajikistan">Tajikistan</option> 
<option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
<option value="Thailand">Thailand</option> 
<option value="Timor-leste">Timor-leste</option> 
<option value="Togo">Togo</option> 
<option value="Tokelau">Tokelau</option> 
<option value="Tonga">Tonga</option> 
<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
<option value="Tunisia">Tunisia</option> 
<option value="Turkey">Turkey</option> 
<option value="Turkmenistan">Turkmenistan</option> 
<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
<option value="Tuvalu">Tuvalu</option> 
<option value="Uganda">Uganda</option> 
<option value="Ukraine">Ukraine</option> 
<option value="United Arab Emirates">United Arab Emirates</option> 
<option value="United Kingdom">United Kingdom</option> 
<option value="United States">United States</option> 
<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
<option value="Uruguay">Uruguay</option> 
<option value="Uzbekistan">Uzbekistan</option> 
<option value="Vanuatu">Vanuatu</option> 
<option value="Venezuela">Venezuela</option> 
<option value="Viet Nam">Viet Nam</option> 
<option value="Virgin Islands, British">Virgin Islands, British</option> 
<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
<option value="Wallis and Futuna">Wallis and Futuna</option> 
<option value="Western Sahara">Western Sahara</option> 
<option value="Yemen">Yemen</option> 
<option value="Zambia">Zambia</option> 
<option value="Zimbabwe">Zimbabwe</option>
</select></div></td>
                    <td>City <span class="red">*</span><br><div class="jqTransformSelectWrapper" style="z-index: 9; width: 301px;"><div><span style="width: 270px;">-Select-</span><a class="jqTransformSelectOpen" href="#"></a></div><ul style="width: 299px; display: none; visibility: visible; height: 26px; overflow: hidden;"><li><a index="0" href="#" class="selected">-Select-</a></li></ul><select class="selectbox jqTransformHidden" style=""><option>-Select-</option></select></div></td>
                    <td>Your Nationality <span class="red">*</span><br><div class="jqTransformSelectWrapper" style="z-index: 8; width: 301px;"><div><span style="width: 270px;">-Select-</span><a class="jqTransformSelectOpen" href="#"></a></div><ul style="width: 299px; display: none; visibility: visible; height: 26px; overflow: hidden;"><li><a index="0" href="#" class="selected">-Select-</a></li></ul><select class="selectbox jqTransformHidden" style=""><option>-Select-</option></select></div></td>
                  </tr>
                  <tr>
                    <td>Your Birth Date <span class="red">*</span><br><input type="text" class="inputbox" placeholder="YY/MM/DD" value=""></td>
                    <td>GENDER <br><div class="jqTransformSelectWrapper" style="z-index: 7; width: 301px;"><div><span style="width: 270px;">-Select-</span><a class="jqTransformSelectOpen" href="#"></a></div><ul style="width: 299px; display: none; visibility: visible; height: 26px; overflow: hidden;"><li><a index="0" href="#" class="selected">-Select-</a></li></ul><select class="selectbox jqTransformHidden" style=""><option>-Select-</option></select></div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="radios" colspan="3">What's your language preference? <span class="red">*</span><br>
                    	<span class="label"><span class="jqTransformRadioWrapper"><a rel="language" class="jqTransformRadio jqTransformChecked" href="#"></a><input type="radio" checked="" name="language" value="" class="jqTransformHidden"></span> English</span> 
                        <span class="label"><span class="jqTransformRadioWrapper"><a rel="language" class="jqTransformRadio" href="#"></a><input type="radio" name="language" value="" class="jqTransformHidden"></span> Arabic</span> 
                        <span class="label"><span class="jqTransformRadioWrapper"><a rel="language" class="jqTransformRadio" href="#"></a><input type="radio" name="language" value="" class="jqTransformHidden"></span> French</span>
                    </td>
                  </tr>
                  <tr>
                  	<td colspan="3">
                    	<h3 class="blue">Login Information</h3>
                    </td>
                  </tr>
                  <tr>
                    <td>PASSWORD <span class="red">*</span><br><input type="text" class="inputbox" value=""></td>
                    <td>CONFIRM PASSWORD <br><input type="text" class="inputbox" value=""></td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody></table>
                <p>By creating an account, you agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
            <div class="block_footer">
                <div class="floatleft"><input type="button" value="BACK" class="back"></div>
                <div class="floatright"><input type="button" class="submit" value="CREATE AN ACCOUNT"></div>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        
<?php } else { ?>
<h1 class="title">Create a Free Account</h1>
	<p class="font16">Get instant access to the tools necessary for finding a job in the Middle East.</p>
	<div class="social_register">
    	<label>SOCIAL SING UP</label>
        	<a href="#"><img src="<?=IMAGES_URL?>login_facebook.png" alt=""></a> 
            <a href="#"><img src="<?=IMAGES_URL?>login_twitter.png" alt=""></a>
	</div>
    <div class="seperator">
    	<span class="or">or</span>
    </div>
            <h2 class="title">Register Using Your Email (it will only take a minute!)<span class="floatright orng">* Required Fields</span>.</h2>
<form name="myform" id="myform" enctype="multipart/form-data" action="" method="post"> 
    <div class="form">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td>FIRST NAME <span class="red">*</span><br><?php echo $this->myform->user_fname?></td>
    <td>LAST NAME <span class="red">*</span><br><?php echo $this->myform->user_lname?></td>
    <td>
    EMAIL <span class="red">*</span><br><?php echo $this->myform->user_email?>
    <input type="hidden" name="user_type" id="user_type" value="<? echo $_REQUEST['user_type']?>" />
    </td>
    </tr>
    <tr>
    <td>COUNTRY <span class="red">*</span><br>
    <?php echo $this->myform->Country_id?>
    </td>
    <td>City <span class="red">*</span><br><?php echo $this->myform->user_city?></td>
    <td>Your Nationality <span class="red">*</span><br><?php echo $this->myform->Nationality_id?></td>
    </tr>
    <tr>
    <td>Your Birth Date <span class="red">*</span><br>
    <?php echo $this->myform->user_dob?>&nbsp;<img src="<?=APPLICATION_URL?>images/Cal.gif" name="cmdbusinessunit" align="absmiddle" id="cmdbusinessunit" onclick="return displayCalendar(document.myform.user_dob,'dd-mm-yyyy',this)"/>
    <!--<input type="text" value="" placeholder="YY/MM/DD" class="inputbox">-->
    </td>
    <td>GENDER <br><?php echo $this->myform->user_gender?>
    <!--<select class="selectbox"><option>-Select-</option></select>-->
    </td>
    <td><input type="hidden" class="inputbox" value="" id="my_dob" name="my_dob"></td>
    </tr>
    <tr>
    <td colspan="3" class="radios">What's your language preference? <span class="red">*</span><br><br />
    <?php echo $this->myform->user_language_preference?>
    <!--<label><input type="radio" name="user_language_preference" value=""> English</label> 
    <label><input type="radio" name="user_language_preference" value=""> Arabic</label> 
    <label><input type="radio" name="user_language_preference" value=""> French</label>-->
    </td>
    </tr>
    <tr>
    <td colspan="3">
    <h3 class="blue">Login Information</h3>
    </td>
    </tr>
    <tr>
    <td>PASSWORD <span class="red">*</span><br>
    <?php echo $this->myform->user_password?>
    <!--<input type="text" value="" class="inputbox">-->
    </td>
    <td>CONFIRM PASSWORD <br>
    <?php echo $this->myform->confirm_user_password?>
    <!--<input type="text" value="" class="inputbox">-->
    </td>
    
    <td>&nbsp;</td>
    </tr>
    </table>
        <p>By creating an account, you agree to our Terms of Use and Privacy Policy.</p>
    </div>
    <div class="block_footer">
        <div class="floatleft">
            <input type="button" class="back" value="BACK">
        </div>
        <div class="floatright">
    <input type="submit" value="CREATE AN ACCOUNT" class="submit" onclick="">
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</form>
   
</div>        
<? } ?>