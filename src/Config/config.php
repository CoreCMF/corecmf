<?php
return [
    'name' => 'corecmf',
    'description' => 'corecmf',
    'author' => 'bigRocs',
    'providers' => [
            CoreCMF\Admin\AdminServiceProvider::class,  //admin
            CoreCMF\Core\CoreServiceProvider::class,  //CoreServiceProvider
    ],
    //安装检测 php 版本 php扩展 目录权限
    'prerequisite' => [
        'phpVersion' => '5.6.4',
        'phpExtension' => [
            'DOM',
            'FileInfo',
            'GD',
            'Json',
            'Mbstring',
            'OpenSSL',
            'PDO',
            'PDO_mysql',
            'XML',
            'Tokenizer'
        ],
        'writablePath' => [
            public_path(),
            storage_path(),
        ]
    ],
    'agreement' => '
			<p>Apache 许可协议, 版本 2.0</p>
			<p>Apache License</p>
			<p>版本 2.0，2004 年1月</p>
			<p>http://www.apache.org/licenses/</p>
			<p>使用复制及分发的条款与条件</p>
			<p>1. 定义.</p>
			<p>“许可”是指从本文档1 到 9节所定义的使用、复制及分发的条款。</p>
			<p>“授权人”是指版权拥有者或由版权拥有者授权许可的实体。</p>
			<p>“法律实体”是指代理团体及控制、受该实体共同控制的所有其他团体。关于这个定义的用途，“控制”意思是
					(i)直接或间接地无论是通过合同或其他方式操纵这样实体的引导方向或管理，或者(ii)
					流通股百分之五十（50%）以上的拥有，或者(iii)这样实体有权受益的拥有。</p>
			<p>“你”（或“你的”）只行使本许可授权的权限的个人或法律实体。</p>
			<p>“源”形式指做出修改的首选形式，包括但不限于软件源代码、文档源代码及配置文件。</p>
			<p>“目标”形式指从一种源形式机械地转换或翻译而产生的任何形式，包括但不限于编译的目标代码、生成的文档及其他媒体类型的转换。</p>
			<p>“作品”是指根据本许可协议可用的原作者的作品，无论是源形式还是目标形式的，如包含或附加在作品中的版权声明所示的（下面的附录提供了一个例子）。</p>
			<p>
					“派生的作品”指无论是源形式还是目标形式的基于作品（或从其派生的）任何作品，整体上，原作者的原作品的编辑修改、标注、修饰或者其他的修改形式。对于本许可的这种用途，派生的作品不能包含与原作品分离的，或者仅仅到接口的链接（或者按名称绑定的）从而派生的作品。</p>
			<p>
					“奉献”指任何原作者的作品，包括作品的原始版本及对该作品或派生作品的任何修改与增补，即有意提交给授权人，或者由个人或者法律实体代表版权拥有者提交给授权人，由作品的版本拥有者包含在作品中。对于这个定义的用途，“提交”意思是发送给授权人或其代表的任何形式的，电子的、口头或书面交流，包括但不限于电子邮件列表、由授权人出于讨论及改进作品目的的源代码控制系统及问题跟踪系统，但是不包括由版权拥有者明确地标记或者书面指定为“非奉献”的交流。</p>
			<p>“奉献者”指授权人及代表其奉献由授权人接受并后来包含到作品中的任何个人或者法律实体。</p>
			<p>2. 授予版权许可.
					按照本许可的条款，每个奉献者授予您一个永久的、全球性的、非排他性的、不收费，免版税的，不可撤销的版权许可证，许可您以源形式或目标形式复制、准备派生作品、公开展示、公开表演、再授权、分发作品及派生作品。</p>
			<p>3. 授予专利许可.
					按照本许可的条款，每个奉献者授权您一个永久性、全球的、非排他性的、不收费、免版税的、不可撤销的（除本节所述）专利实施许可，可以创建、使用、许诺销售、销售、引进及转换作品，其中这样的许可只适用于因其奉献者单独或者与其奉献者与提交的作品结合而受到侵犯的这些奉献者授权的那些专利声明。如果您针对任何实体提起诉讼（包括反诉或诉讼中的反诉），主张作品或者纳入到作品中的奉献构成直接或间接的侵犯，那么按本许可授权您该作品的任何专利许可在提起诉讼之时终止。</p>
			<p>4. 再分发. 您可以任何媒体形式，无论是否修改，以源或目标形式复制和分发作品或派生作品的副本，只要你符合下列条件：</p>
			<p>您必须给予作品或派生作品的任何其他的接收者以本许可，并</p>
			<p>您必须对于任何修改过的文件带有明显的声明，说明你改变了这个文件；而且</p>
			<p>您必须用您分发的任何派生作品的源形式保留，作品源形式的所有的版权、专利、商标及属性声明，不包括不输入派生作品的任何部分的那些说明；而且</p>
			<p>
					如果作品包含一个“声明”文本文件作为其分发的部分，那么你分发的任何派生的作品必须在至少下面的地方之一，包含这样的声明文件在内的一个包含该属性声明的可读的副本，不包含不属于派生作品的任何部分的那些：在作为派生作品的部分分发的一个声明文件之内；在源代形式或者文档中，如果随着派生的作品提供的话；或者在由派生作品生成的显示中，如果在第三方声明出现的任何地方。这个声明文件的内容是只是信息性用途的，不修改许可协议。您可以在您分发的派生作品中添加你自己的属性声明，如果这样额外的属性声明不能构造为对许可协议的修改的话，那么与作品的声明文本一起或作为附录。你可以给你的修改添加你自己的版权声明，可以提供使用、复制或分发你的修改的不同的许可协议条款，或者对于任何这样的派生作品整体上，只要您的使用、复制及分发作品符合本许可规定的条件。</p>
			<p>5. 奉献的提交.
					除非你明确地不同地声明，否则按照本许可协议的条款任何由您向授权人提交的奉献都有意包含在作品中而没有任何额外的条款。尽管如上所述，但是任何情况下均不得取代或修改你也许已经与授权人执行的关于奉献的任何许可协议条款。</p>
			<p>6. 商标.
					本许可不授予许可权限使用授权人的商品名称、商标、服务标记、或产品名称，除了用于说明原作品及声明作品的声明文件的内容需要的合理及习惯使用之外。</p>
			<p>7. 免责条款.
					除非适用法律或者书面同意的需要，授权人都“原样”提供作品（及每个奉献者提供其奉献），无任何形式的无论是明确的还是隐含的担保或条款，包括但不限于标题、非侵权性，适销性或针对特定用途的适用性的担保或条款。您唯一地确定对作品的使用或再分发是否合适，并承担与你行使本许可权限相关的任何风险。</p>
			<p>8. 责任限制.
					在任何情况下，没有有法律理论，在是否侵权（包括过失）、合同或者否则因适用法律的需要（如故意和疏忽行为）或者书面同意任何风险者对您的伤害负责，包括任何直接、间接的、特殊的、偶然的或者任何特征的引起的伤害（包括但不限于商誉损失，工作停止，计算机故障或失灵，或任何和所有其他商业损害或损失），即使这样的奉献者已被告知此类损害的可能性。</p>
			<p>9. 接受保证或附加责任.
					在再分发作品及派生作品时，你可以选择提供、并收取一定的费用、接受支持、担保、免除或者其他的责任义务及/或符合本许可的权限。但是，接受这些义务时您可以仅以进自己的名义，仅对您自己的行动负责，而不代表任何其他的奉献者，如果你由这样的奉献者因接受任何这样的担保及附带责任引起或针对其主张的任何义务同意赔偿、辩护，保证对每个奉献者无害。</p>
			<p>条款结束</p>
			<p>附录: 如何应用Apache 许可到您的作品</p>
			<p>要对您的作品应用 Apache
					许可，添加下面的样本声明，用你自己的区别性信息替换括号封闭的字段。（不要包含括号！）。这段文本应该用文件格式的合适的注释语法封闭起来。我还推荐在与版权声明相同的“打印页”上包含一个文件或者类名及用途说明，更容易在第三方文件之内区分。</p>
			<p>版权所有 [ibenchu.com] [陕西本初网络科技有限公司]</p>
			<p>根据 Apache 许可证2.0 版（以下简称“许可证”）授权；</p>
			<p>除非遵守本许可，否则您不能使用这个文件。</p>
	',
];
