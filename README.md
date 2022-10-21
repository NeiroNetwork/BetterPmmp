# BetterPmmp

## 変更一覧

これらの変更は設定ファイルから有効/無効化できます。

### RestrictColoredText

OP権限を持っていないプレイヤーによる文字の装飾を禁止します。  
参考: <https://github.com/NeiroNetwork/RestrictColoredText>

### DisableComboGlitch

俗に言う切り替え攻撃を無効化します。  
参考: <https://github.com/NeiroNetwork/AttackDelayController>

### SimplePlayerList

メニューに表示されるプレイヤーリストをバニラのよう(プレイヤーの名前のみ)にします。  
チャットでプレイヤーをメンションするときに、余計な文字を含まなくなります。

### VanillaLikeChat

プレイヤーチャットをMinecraft標準の方法で送信します。  
クライアントサイドによるチャットミュートが機能するようになります。

### LimitedEnderPearl

プレイヤーが死亡した時・他のワールドへテレポートした時に、そのプレイヤーが投げたエンダーパールを無効化します。

### FixFallDamageHeight

2ブロックの高さからジャンプするとダメージが受ける問題を一時的に修正します。  
(イベントをキャンセルするだけなので、落下ダメージの音などは消えません)  
参照: <https://github.com/pmmp/PocketMine-MP/issues/4686>

### DisableBreakSpectator

ゲームモードをスペクテイターに変更した際に、ブロックを破壊できないようにします。  
参照: <https://github.com/pmmp/PocketMine-MP/pull/5313>

### ArrowHitSound

プレイヤーがエンティティに弓矢を当てた際に、攻撃者に効果音を再生します。  
本来はプレイヤーに当てた場合のみに再生されるのが正しいバニラの挙動です: <https://minecraft.fandom.com/wiki/Bow#Sounds>
