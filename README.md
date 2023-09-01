# BetterPmmp

## 変更一覧

これらの変更は設定ファイルから有効/無効化できます。

### AddEducationItems

クリエイティブインベントリに Education Edition のアイテムをいくつか追加し、要素ブロックを最後に移動させます。  
参考: <https://github.com/NeiroNetwork/ExperimentalFeatures> [CreativeContentsRegister.php](https://github.com/NeiroNetwork/ExperimentalFeatures/blob/686c3973cdcfc221c75b9bf1eea657d846779302/src/register/CreativeContentsRegister.php)

### ArrowHitSound

プレイヤーがエンティティに弓矢を当てた際に、攻撃者に効果音を再生します。  
本来はプレイヤーに当てた場合のみに再生されるのが正しいバニラの挙動です: <https://minecraft.fandom.com/wiki/Bow#Sounds>

### DisableBreakingBySpectator

OP権限を持っているプレイヤーがスペクテイターでブロックを破壊できてしまう問題を修正します。  
参照: <https://github.com/pmmp/PocketMine-MP/pull/5313>

### DisableComboGlitch

俗に言う切り替え攻撃を無効化します。  
参考: <https://github.com/NeiroNetwork/AttackDelayController>

### FixFallDamageCalculation

[FixFallDamageHeight](#fixfalldamageheight) とは違い、プレイヤークラスの落下ダメージの計算を上書きして修正します。  
プレイヤークラスの上書きは非協力的であったり、見た目をよくするためのひどいハックが用いられているため、デフォルトでは無効になっています。

### FixFallDamageHeight

2ブロックの高さからジャンプするとダメージが受ける問題を一時的に修正します。  
(イベントをキャンセルするだけなので、落下ダメージの音などは消えません)  
参照: <https://github.com/pmmp/PocketMine-MP/issues/4686>

### FixGhostWater

はしごなどの水没するブロックに水を設置しようとすると、クライアント側に水が残ってしまうバグを修正します。  
参考: <https://github.com/NeiroNetwork/ExperimentalFeatures> [WaterBucketFixer.php](https://github.com/NeiroNetwork/ExperimentalFeatures/blob/686c3973cdcfc221c75b9bf1eea657d846779302/src/override/expert/item/WaterBucketFixer.php)

### LimitedEnderPearl

プレイヤーが死亡した時・他のワールドへテレポートした時に、そのプレイヤーが投げたエンダーパールを無効化します。

### RestrictColoredText

OP権限を持っていないプレイヤーによる文字の装飾を禁止します。  
参考: <https://github.com/NeiroNetwork/RestrictColoredText>

### SimplePlayerList

メニューに表示されるプレイヤーリストをバニラのよう(プレイヤーの名前のみ)にします。  
チャットでプレイヤーをメンションするときに、余計な文字を含まなくなります。

### SuppressSelfEmoteText

エモートした際のメッセージがプレイヤー自身に表示されないようにします。
似たプラグイン: <https://github.com/nhanaz-pm-pl/NoEmoteMessage>
