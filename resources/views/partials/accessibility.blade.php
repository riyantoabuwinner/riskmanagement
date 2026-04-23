{{-- Accessibility Widget - Self-contained partial --}}
<style>
    /* ── Accessibility FAB ── */
    #accWidget{position:fixed!important;bottom:100px!important;right:28px!important;z-index:9999999!important;font-family:'Inter',sans-serif!important}
    #accFab{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#059669,#10b981);color:#fff;border:3px solid #fff;box-shadow:0 8px 32px rgba(0,0,0,.3);cursor:pointer;font-size:1.4rem;display:flex;align-items:center;justify-content:center;transition:all .3s;animation:accPulse 2s infinite}
    
    /* ── AI FAB ── */
    #aiWidget{position:fixed!important;bottom:28px!important;right:28px!important;z-index:9999999!important;font-family:'Inter',sans-serif!important}
    #aiFab{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border:3px solid #fff;box-shadow:0 8px 32px rgba(245,158,11,.4);cursor:pointer;font-size:1.4rem;display:flex;align-items:center;justify-content:center;transition:all .3s}
    #aiFab:hover{transform:scale(1.1) rotate(10deg);box-shadow:0 12px 40px rgba(245,158,11,.6)}
    
    #accFab:hover{transform:scale(1.1) rotate(5deg);box-shadow:0 12px 40px rgba(5,150,105,.5)}
    @keyframes accPulse{0%{box-shadow:0 0 0 0 rgba(5,150,105,.6)}70%{box-shadow:0 0 0 18px rgba(5,150,105,0)}100%{box-shadow:0 0 0 0 rgba(5,150,105,0)}}

    /* ── Panel ── */
    #accPanel{position:absolute;bottom:75px;right:0;width:320px;background:#fff;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,.25);border:1px solid #e5e7eb;padding:0;display:none;overflow:hidden}
    #accPanel.open{display:block;animation:accSlideUp .3s ease}
    @keyframes accSlideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}

    #accPanel .acc-head{background:linear-gradient(135deg,#047857,#065f46);color:#fff;padding:16px 20px;display:flex;align-items:center;gap:10px;font-weight:700;font-size:.95rem}
    #accPanel .acc-head i{font-size:1.2rem}
    #accPanel .acc-body{padding:16px 18px}

    .acc-section{margin-bottom:14px}
    .acc-section:last-child{margin-bottom:0}
    .acc-section-title{font-size:.72rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.8px;margin-bottom:8px}
    .acc-btns{display:grid;grid-template-columns:1fr 1fr;gap:6px}
    .acc-action{display:flex;align-items:center;justify-content:center;gap:6px;padding:10px 8px;border:1.5px solid #e5e7eb;border-radius:10px;background:#f9fafb;cursor:pointer;font-size:.75rem;font-weight:600;color:#374151;transition:all .2s;user-select:none}
    .acc-action:hover{background:#f0fdf4;border-color:#10b981;color:#047857}
    .acc-action.on{background:#047857!important;color:#fff!important;border-color:#047857!important}
    .acc-action i{font-size:.85rem}

    .acc-footer{text-align:center;padding:10px 18px 14px;border-top:1px solid #f3f4f6}
    .acc-footer small{font-size:.65rem;color:#9ca3af}
    .acc-reset{background:none;border:none;color:#ef4444;font-size:.72rem;font-weight:600;cursor:pointer;padding:4px 8px;border-radius:6px;transition:all .2s}
    .acc-reset:hover{background:#fef2f2}

    /* ── Global Accessibility Overrides ── */
    html.acc-hc *{filter:contrast(1.4)!important}
    html.acc-hc body{background:#000!important;color:#fff!important}
    html.acc-dyslexic *{font-family:'OpenDyslexic','Comic Sans MS',cursive,sans-serif!important}
    html.acc-large-cursor *{cursor:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32'%3E%3Ccircle cx='16' cy='16' r='14' fill='%23047857' opacity='.5'/%3E%3C/svg%3E") 16 16,auto!important}
    html.acc-underline a{text-decoration:underline!important;text-underline-offset:3px!important}
    html.acc-reading-guide .acc-reading-line{display:block!important}

    .acc-reading-line{display:none!important;position:fixed;left:0;right:0;height:40px;border-top:2px solid #047857;border-bottom:2px solid #047857;background:rgba(4,120,87,.06);z-index:999998;pointer-events:none;transition:top .05s linear}

    @font-face{font-family:'OpenDyslexic';src:url('https://cdn.jsdelivr.net/npm/opendyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype')}

    /* ── TTS Active Highlight ── */
    .acc-speaking{outline:2px dashed #047857;outline-offset:2px;background:rgba(4,120,87,.05)!important}
    .acc-hc img, .acc-hc video{filter:contrast(1.2) brightness(1.1)}
    
    /* ── New Features ── */
    .acc-grayscale{filter:grayscale(100%)!important}
    .acc-invert{filter:invert(100%)!important}
    .acc-line-height{line-height:2!important}
    .acc-letter-spacing{letter-spacing:2px!important}

    /* ── AI Chat UI ── */
    #accChat{position:fixed;bottom:90px;right:28px;width:350px;height:450px;background:#fff;border-radius:24px;box-shadow:0 24px 80px rgba(0,0,0,.3);border:1px solid #e5e7eb;display:none;flex-direction:column;overflow:hidden;z-index:1000000;animation:accSlideUp .4s ease}
    #accChat.open{display:flex}
    .chat-head{background:linear-gradient(135deg,#047857,#064e3b);color:#fff;padding:16px 20px;display:flex;align-items:center;justify-content:space-between}
    .chat-body{flex:1;overflow-y:auto;padding:15px;display:flex;flex-direction:column;gap:12px;background:#f8fafc}
    .chat-msg{max-width:85%;padding:10px 14px;border-radius:18px;font-size:.85rem;line-height:1.4}
    .msg-ai{background:#fff;color:#1e293b;align-self:flex-start;border-bottom-left-radius:4px;box-shadow:0 2px 8px rgba(0,0,0,.05)}
    .msg-user{background:#047857;color:#fff;align-self:flex-end;border-bottom-right-radius:4px}
    .chat-input-area{padding:12px;background:#fff;border-top:1px solid #e5e7eb;display:flex;gap:8px}
    .chat-input{flex:1;border:1px solid #e5e7eb;border-radius:20px;padding:8px 16px;font-size:.85rem;outline:none}
    .chat-send{background:#047857;color:#fff;border:none;width:36px;height:36px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center}

    @media print{#accWidget{display:none!important}}
</style>

<div id="accWidget">
    <div id="accPanel">
        <div class="acc-head"><i class="fas fa-universal-access"></i> Aksesibilitas</div>
        <div class="acc-body">
            <!-- ── TTS ── -->
            <div class="acc-section">
                <div class="acc-section-title"><i class="fas fa-volume-up"></i> Baca Teks (TTS)</div>
                <div class="acc-btns">
                    <div class="acc-action" id="accTtsPlay" onclick="accTTS.toggle()"><i class="fas fa-volume-up"></i> <span id="accTtsText">Mode Baca: OFF</span></div>
                </div>
            </div>

            <!-- ── Visual Filters ── -->
            <div class="acc-section">
                <div class="acc-section-title"><i class="fas fa-eye-dropper"></i> Filter Visual</div>
                <div class="acc-btns">
                    <div class="acc-action" id="accBtnGrayscale" onclick="accToggle('grayscale')"><i class="fas fa-adjust"></i> Hitam Putih</div>
                    <div class="acc-action" id="accBtnInvert" onclick="accToggle('invert')"><i class="fas fa-fill-drip"></i> Invert Warna</div>
                </div>
            </div>

            <!-- ── Spacing ── -->
            <div class="acc-section">
                <div class="acc-section-title"><i class="fas fa-arrows-alt-v"></i> Spasi & Tata Letak</div>
                <div class="acc-btns">
                    <div class="acc-action" id="accBtnLineHeight" onclick="accToggle('lineHeight')"><i class="fas fa-text-height"></i> Spasi Baris</div>
                    <div class="acc-action" id="accBtnLetterSpacing" onclick="accToggle('letterSpacing')"><i class="fas fa-arrows-alt-h"></i> Spasi Huruf</div>
                </div>
            </div>

            {{-- Font Size --}}
            <div class="acc-section">
                <div class="acc-section-title"><i class="fas fa-text-height"></i> Ukuran Teks</div>
                <div class="acc-btns">
                    <div class="acc-action" onclick="accFont(-10)"><i class="fas fa-search-minus"></i> Kecilkan</div>
                    <div class="acc-action" onclick="accFont(10)"><i class="fas fa-search-plus"></i> Besarkan</div>
                </div>
            </div>

            {{-- Visual --}}
            <div class="acc-section">
                <div class="acc-section-title"><i class="fas fa-eye"></i> Visual</div>
                <div class="acc-btns">
                    <div class="acc-action" id="accBtnHC" onclick="accToggle('hc')"><i class="fas fa-adjust"></i> Kontras Tinggi</div>
                    <div class="acc-action" id="accBtnDyslexic" onclick="accToggle('dyslexic')"><i class="fas fa-font"></i> Disleksia</div>
                    <div class="acc-action" id="accBtnCursor" onclick="accToggle('cursor')"><i class="fas fa-mouse-pointer"></i> Kursor Besar</div>
                    <div class="acc-action" id="accBtnUnderline" onclick="accToggle('underline')"><i class="fas fa-underline"></i> Garis Bawah Link</div>
                </div>
            </div>

            {{-- AI Assistant Section in Acc Panel --}}
            <div class="acc-section">
                <div class="acc-section-title"><i class="fas fa-robot"></i> Asisten AI</div>
                <div class="acc-btns">
                    <div class="acc-action" onclick="accAI.open()"><i class="fas fa-comments"></i> Buka Chat AI</div>
                </div>
            </div>

            {{-- Alat Bantu --}}
            <div class="acc-section">
                <div class="acc-section-title"><i class="fas fa-tools"></i> Alat Bantu</div>
                <div class="acc-btns">
                    <div class="acc-action" id="accBtnGuide" onclick="accToggle('guide')"><i class="fas fa-grip-lines"></i> Panduan Baca</div>
                    <div class="acc-action" onclick="accReset()"><i class="fas fa-undo"></i> Reset Semua</div>
                </div>
            </div>
        </div>
        <div class="acc-footer">
            <small>Bahasa TTS: <strong id="accLangLabel">Indonesia</strong></small>
        </div>
    </div>
    <button id="accFab" title="Menu Aksesibilitas" onclick="document.getElementById('accPanel').classList.toggle('open')">
        <i class="fas fa-universal-access"></i>
    </button>
</div>

{{-- AI Assistant Widget --}}
<div id="aiWidget">
    <button id="aiFab" title="Tanya RiskGuard AI" onclick="accAI.open()">
        <i class="fas fa-robot"></i>
    </button>
</div>

{{-- AI Chatbot Window --}}
<div id="accChat">
    <div class="chat-head">
        <div style="display:flex;align-items:center;gap:10px">
            <i class="fas fa-robot"></i>
            <div>
                <div style="font-weight:700;font-size:.9rem">RiskGuard AI</div>
                <div style="font-size:.65rem;opacity:.8">Asisten Pintar Manajemen Risiko</div>
            </div>
        </div>
        <i class="fas fa-times" style="cursor:pointer" onclick="accAI.close()"></i>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="chat-msg msg-ai">Halo! Saya RiskGuard AI. Ada yang bisa saya bantu terkait penggunaan aplikasi Manajemen Risiko ini?</div>
    </div>
    <div class="chat-input-area">
        <input type="text" class="chat-input" id="chatInput" placeholder="Tanyakan sesuatu..." onkeypress="if(event.key==='Enter') accAI.send()">
        <button class="chat-send" onclick="accAI.send()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

{{-- Reading Guide Line --}}
<div class="acc-reading-line" id="accReadingLine"></div>

<script>
(function(){
    /* ── State ── */
    var state = {};
    try {
        state = JSON.parse(localStorage.getItem('acc-state') || '{}');
    } catch(e) { console.warn('ACC: Failed to parse state', e); state = {}; }
    var html = document.documentElement;

    /* ── Apply saved state ── */
    if(state.fontSize) document.body.style.fontSize = state.fontSize + '%';
    if(state.hc) html.classList.add('acc-hc');
    if(state.dyslexic) html.classList.add('acc-dyslexic');
    if(state.cursor) html.classList.add('acc-large-cursor');
    if(state.underline) html.classList.add('acc-underline');
    if(state.guide) html.classList.add('acc-reading-guide');

    function save(){ localStorage.setItem('acc-state', JSON.stringify(state)); }
    function syncButtons(){
        var map = {hc:'accBtnHC',dyslexic:'accBtnDyslexic',cursor:'accBtnCursor',underline:'accBtnUnderline',guide:'accBtnGuide',grayscale:'accBtnGrayscale',invert:'accBtnInvert',lineHeight:'accBtnLineHeight',letterSpacing:'accBtnLetterSpacing'};
        for(var k in map){
            var el = document.getElementById(map[k]);
            if(el){ if(state[k]) el.classList.add('on'); else el.classList.remove('on'); }
        }
    }

    /* ── Toggle Feature ── */
    window.accToggle = function(key){
        state[key] = !state[key];
        var classMap = {hc:'acc-hc',dyslexic:'acc-dyslexic',cursor:'acc-large-cursor',underline:'acc-underline',guide:'acc-reading-guide',grayscale:'acc-grayscale',invert:'acc-invert',lineHeight:'acc-line-height',letterSpacing:'acc-letter-spacing'};
        if(classMap[key]) html.classList.toggle(classMap[key], state[key]);
        save(); syncButtons();
    };

    /* ── Font Size ── */
    window.accFont = function(delta){
        state.fontSize = Math.min(Math.max((state.fontSize||100) + delta, 70), 160);
        document.body.style.fontSize = state.fontSize + '%';
        save();
    };

    /* ── Reset ── */
    window.accReset = function(){
        state = {};
        localStorage.removeItem('acc-state');
        document.body.style.fontSize = '';
        html.className = html.className.replace(/acc-\S+/g,'').trim();
        syncButtons();
        if(window.accTTS) accTTS.stop();
    };

    /* ── Reading Guide (mouse follow) ── */
    document.addEventListener('mousemove', function(e){
        if(state.guide){
            var line = document.getElementById('accReadingLine');
            if(line) line.style.top = (e.clientY - 20) + 'px';
        }
    });

    /* ── Close panel on outside click ── */
    document.addEventListener('click', function(e){
        if(!e.target.closest('#accWidget')){
            var p = document.getElementById('accPanel');
            if(p) p.classList.remove('open');
        }
    });

    /* ── TTS Engine ── */
    window.accTTS = {
        active: false,
        speaking: false,
        toggle: function(){
            this.active = !this.active;
            var btn = document.getElementById('accTtsPlay');
            var txt = document.getElementById('accTtsText');
            if(this.active) {
                if(btn) btn.classList.add('on');
                if(txt) txt.textContent = 'Mode Baca: ON';
                // Try reading current selection immediately if any
                this.readSelection();
            } else {
                if(btn) btn.classList.remove('on');
                if(txt) txt.textContent = 'Mode Baca: OFF';
                window.speechSynthesis.cancel();
            }
        },
        readSelection: function(){
            var synth = window.speechSynthesis;
            if(!synth || !this.active) return;
            
            var selectedText = window.getSelection().toString().trim();
            if(!selectedText || selectedText.length < 2) return;
            
            synth.cancel();
            var text = selectedText.substring(0, 5000);
            var utt = new SpeechSynthesisUtterance(text);
            
            var lang = 'id';
            try {
                var gtCookie = document.cookie.split('; ').find(row => row.trim().startsWith('googtrans='));
                if(gtCookie) lang = gtCookie.split('/').pop();
                else lang = document.documentElement.lang.split('-')[0] || 'id';
            } catch(e) { lang = 'id'; }

            var langMap = {id:['id-ID','id'],en:['en-US','en-GB','en'],ar:['ar-SA','ar']};
            var targetCodes = langMap[lang] || langMap['id'];
            
            var voices = synth.getVoices();
            var voice = voices.find(v => targetCodes.some(c => v.lang.toLowerCase().includes(c.toLowerCase())));
            if(voice) utt.voice = voice;
            
            utt.lang = targetCodes[0];
            utt.rate = 1.0;
            var self = this;
            utt.onstart = function(){ self.speaking = true; };
            utt.onend = function(){ self.speaking = false; };
            utt.onerror = function(){ self.speaking = false; };

            synth.resume();
            synth.speak(utt);
        }
    };

    // Global listener for automatic reading when mode is active
    document.addEventListener('mouseup', function(){
        if(window.accTTS && window.accTTS.active) {
            // Small delay to ensure selection is complete
            setTimeout(function(){ window.accTTS.readSelection(); }, 100);
        }
    });

    /* ── AI Assistant Logic ── */
    window.accAI = {
        open: function(){ document.getElementById('accChat').classList.add('open'); },
        close: function(){ document.getElementById('accChat').classList.remove('open'); },
        send: function(){
            var input = document.getElementById('chatInput');
            var text = input.value.trim();
            if(!text) return;
            
            this.addMsg(text, 'user');
            input.value = '';
            
            var self = this;
            setTimeout(function(){ self.respond(text); }, 600);
        },
        addMsg: function(text, role){
            var body = document.getElementById('chatBody');
            var div = document.createElement('div');
            div.className = 'chat-msg msg-' + role;
            div.textContent = text;
            body.appendChild(div);
            body.scrollTop = body.scrollHeight;
        },
        respond: function(q){
            q = q.toLowerCase();
            var res = "Maaf, saya belum memiliki informasi spesifik mengenai hal tersebut. Anda bisa bertanya tentang: Cara input risiko, Role pengguna, Matriks risiko, Cara cetak laporan, atau Fitur mitigasi.";
            
            // Basic & Identity
            if(q.includes('halo') || q.includes('hi') || q.includes('pagi') || q.includes('siang')) {
                res = "Halo! Saya asisten RiskGuard AI. Saya siap membantu Anda mengoperasikan sistem manajemen risiko ini. Apa yang ingin Anda ketahui?";
            }
            else if(q.includes('aplikasi') || q.includes('sistem ini') || q.includes('apa ini')) {
                res = "Ini adalah Sistem Manajemen Risiko UIN Siber Syekh Nurjati Cirebon. Aplikasi ini membantu institusi mengelola risiko secara digital berdasarkan framework ISO 31000:2018.";
            }
            
            // Roles & Access
            else if(q.includes('role') || q.includes('peran') || q.includes('siapa yang')) {
                res = "Sistem memiliki 4 level akses: <br>1. **Super Admin**: Kelola user & sistem.<br>2. **Risk Manager**: Validasi & laporan akhir.<br>3. **Risk Officer**: Analisis & evaluasi teknis.<br>4. **Risk Owner**: Input risiko di unit kerja.";
            }
            else if(q.includes('password') || q.includes('lupa sandi') || q.includes('ganti password')) {
                res = "Untuk ganti password, klik nama Anda di pojok kanan atas dashboard, pilih 'Profile', lalu masuk ke bagian 'Update Password'.";
            }

            // Risk Management Process
            else if(q.includes('cara') && (q.includes('input') || q.includes('tambah')) && q.includes('risiko')) {
                res = "Langkah input risiko:<br>1. Buka menu **Daftar Risiko**.<br>2. Klik tombol **Tambah Risiko**.<br>3. Isi Nama Risiko, Penyebab, dan Dampak.<br>4. Tentukan nilai Probabilitas & Dampak awal.<br>5. Simpan.";
            }
            else if(q.includes('matriks') || q.includes('heatmap') || q.includes('5x5')) {
                res = "Sistem menggunakan Matriks 5x5. Level risiko dihitung dari **Probabilitas × Dampak**. <br>- 1-5: Low (Hijau)<br>- 6-10: Medium (Kuning)<br>- 11-15: High (Oranye)<br>- 16-25: Extreme (Merah).";
            }
            else if(q.includes('mitigasi')) {
                res = "Mitigasi adalah rencana aksi untuk menangani risiko. Setelah input risiko, Risk Owner mengusulkan mitigasi, dan akan dievaluasi oleh Risk Officer untuk memantau efektivitasnya.";
            }
            
            // Monitoring & Reports
            else if(q.includes('monitoring') || q.includes('pantau')) {
                res = "Menu Monitoring digunakan untuk mencatat progres real-time dari setiap rencana mitigasi yang sedang berjalan.";
            }
            else if(q.includes('laporan') || q.includes('cetak') || q.includes('pdf') || q.includes('excel')) {
                res = "Anda dapat mencetak laporan melalui menu **Laporan**. Tersedia opsi ekspor ke PDF untuk dokumen resmi atau Excel untuk pengolahan data lebih lanjut.";
            }
            
            // Technical/Admin
            else if(q.includes('unit') || q.includes('unit kerja')) {
                res = "Admin dapat mengelola data Unit Kerja dan Jenis Unit melalui menu Manajemen Unit. Data ini penting sebagai referensi saat input risiko.";
            }
            else if(q.includes('audit') || q.includes('log')) {
                res = "Fitur Audit Log mencatat setiap aktivitas user (siapa, kapan, melakukan apa) untuk menjaga keamanan dan transparansi data.";
            }
            else if(q.includes('terima kasih') || q.includes('thanks')) {
                res = "Sama-sama! Senang bisa membantu. Ada lagi yang ingin Anda tanyakan?";
            }
            
            this.addMsg(res, 'ai');
        }
    };

    /* Preload voices */
    if(window.speechSynthesis){
        if (speechSynthesis.onvoiceschanged !== undefined) {
            speechSynthesis.onvoiceschanged = function() { speechSynthesis.getVoices(); };
        }
        speechSynthesis.getVoices();
    }

    /* ── Sync buttons on load ── */
    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', syncButtons);
    } else {
        syncButtons();
    }
})();
</script>
