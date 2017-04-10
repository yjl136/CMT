<div id="keyboard" style="display:none;">
    <div class="keyInputWrapper" id="keyInputWrapper">
        <a  href="javascript:closeKeyboard();" class="close"></a>
        <div class="keyInput"><input name="myInput" type="text" id="myInput" onFocus="get()"/></div>
        <a href="javascript:key_submit();" class="key_submit"></a>
        <div id="choiceWrapper" class="choiceWrapper" style="display:none">
            <a href="javascript:prePage();" id="prePage" class="prePage"></a>
            <input name="" type="text" id="ch_str" class="ch_str"/>
            <div class="choiceShow"><div id="choice" class="choice"></div></div>
            <a href="javascript:nextPage();" id="nextPage" class="nextPage"></a>
        </div>
        <div class="keyRow" id="showKeyboard">
            <div class="keyRow1">
                <a href="javascript:void(0);"><input type="button" value="1" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="2" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="3" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="4" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="5" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="6" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="7" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="8" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="9" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="0" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);" class="dash"><input type="button" name="key_dash" value="" onclick="dash(45)" /></a>
                <a class="del" href="javascript:void(0);"><input type="button" name="key_del" id="key_del" value=""  onclick="backSpaceKey()" /></a>
            </div>
            <div class="keyRow2">
                <a href="javascript:void(0);"><input type="button" value="q" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="w" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="e" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="r" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="t" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="y" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="u" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="i" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="o" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="p" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" id="key_question_mark" value="?" onclick="input(this.value)" /></a>
            </div>
            <div class="keyRow3">
                <a href="javascript:void(0);" class="lowerCase" id="key_lower_left" onclick="changeToLowerUpper()"></a>
                <a href="javascript:void(0);"><input type="button" value="a" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="s" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="d" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="f" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="g" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="h" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="j" class="keyNormal" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="k" class="keyNormal" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="l" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" id="key_comma" value="," onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="key_full_stop" value="." onclick="input(this.value)"/></a>
            </div>
            <div class="keyRow4">
                <a href="javascript:void(0);" class="en_langu" id="key_langu" onclick="chinaToEnglish()"></a>
                <a href="javascript:void(0);"><input type="button" value="z" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="x" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" value="c" class="keyNormal" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="v" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="b" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" value="n" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" value="m" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);" class="key_black"><input type="button" value="" onclick="dash(32)"/></a>
                <a href="javascript:void(0);" class="key_emb" onclick="letterToEmb()"></a>
            </div>
        </div>
        <div class="keyRow" id="showEmbKey" style="display:none">
            <div class="keyRow1">
                <a href="javascript:void(0);"><input type="button" value="！" id="emb_1_1" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);" class="at"><input type="button" value="" onclick="dash(64)" /></a>
                <a href="javascript:void(0);"><input type="button" value="#" onclick="dash(35)" /></a>
                <a href="javascript:void(0);"><input type="button" value="$" onclick="dash(36)"/></a>
                <a href="javascript:void(0);"><input type="button" value="%" onclick="dash(37)"/></a>
                <a href="javascript:void(0);"><input type="button" value="^" onclick="dash(94)" /></a>
                <a href="javascript:void(0);"><input type="button" value="&" onclick="dash(38)"/></a>
                <a href="javascript:void(0);"><input type="button" value="*" onclick="dash(42)" /></a>
                <a href="javascript:void(0);"><input type="button" id="emb_1_9" value="（" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" id="emb_1_10" value="）" onclick="input(this.value)" /></a>
                <a href="javascript:void(0);"><input type="button" id="emb_1_11" value="—" onclick="input(this.value)" /></a>
                <a class="del" href="javascript:void(0);"><input type="button" id="key_del" value=""  onclick="backSpaceKey()" /></a>
            </div>
            <div class="keyRow2">
                <a href="javascript:void(0);"><input type="button" value="~" onclick="dash(126)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_2_2" value="·" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" value="{" onclick="dash(123)"/></a>
                <a href="javascript:void(0);"><input type="button" value="}" onclick="dash(123)"/></a>
                <a href="javascript:void(0);"><input type="button" value="&pound;" onclick="dash(163)"/></a>
                <a href="javascript:void(0);"><input type="button" value="¥" onclick="dash(165)"/></a>
                <a href="javascript:void(0);"><input type="button"  value="=" onclick="dash(61)"/></a>
                <a href="javascript:void(0);"><input type="button" value="|" onclick="dash(124)"/></a>
                <a href="javascript:void(0);"><input type="button" value="/" onclick="dash(47)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_2_10" value='、' onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_2_11" value="？" onclick="input(this.value)"/></a>
            </div>
            <div class="keyRow3">
                <a href="javascript:void(0);"><input type="button" value="㎡" onclick="dash(13217)"/></a>
                <a href="javascript:void(0);"><input type="button"  id="emb_3_2" value="【" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_3" value="】" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_4" value="‘" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_5" value="'" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_6" value='“' onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_7" value='”' onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" value='…' onclick="dash(8230)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_9" value="：" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_10" value=";" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_11" value="，" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_3_12" value="。" onclick="input(this.value)"/></a>
            </div>
            <div class="keyRow4">
                <a href="javascript:void(0);" class="key_abc" onclick="embToLetter()"></a>
                <a href="javascript:void(0);"><input type="button" value='‰' onclick="dash(8240)"/></a>
                <a href="javascript:void(0);"><input type="button" value="+" onclick="dash(43)"/></a>
                <a href="javascript:void(0);"><input type="button" value='√'  onclick="dash(8730)"/></a>
                <a href="javascript:void(0);" class="c"><input type="button" value="" onclick="dash(169)"/></a>
                <a href="javascript:void(0);" class="r"><input type="button" value="" onclick="dash(174)" /></a>
                <a href="javascript:void(0);"><input type="button" id="emb_4_7" value="《" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);"><input type="button" id="emb_4_8" value="》" onclick="input(this.value)"/></a>
                <a href="javascript:void(0);" class="key_black"><input type="button" value="" onclick="dash(32)"/></a>
                <a href="javascript:void(0);" class="key_abc" onclick="embToLetter()"></a>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('/keyboard/js/keyboard.js')}}"></script>