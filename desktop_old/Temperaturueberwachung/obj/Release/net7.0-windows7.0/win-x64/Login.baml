   M S B A M L   `   `   `  ���� Q  MTemperaturueberwachung, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null?$clr-namespace:TemperaturueberwachungTemperaturueberwachung  "    Temperaturueberwachung.Login   W SPresentationCore, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35e aSystem.Windows.Controls.Ribbon, Version=7.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089R NWindowsBase, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35F 9http://schemas.microsoft.com/winfx/2006/xaml/presentation     R NSystem.Xaml, Version=7.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     @d2http://schemas.microsoft.com/expression/blend/2008     Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     6local$clr-namespace:Temperaturueberwachung     -   
������   � Title$  Login��$	��500�� � AllowsTransparency$
 True��$	��350�� � WindowStyle$
 None=� � 
ResizeMode$ NoResize=� � WindowStartupLocation$ CenterScreen=� � Icon$ Assets/Images/logo.ico��.��� .+��� -   ���	#FF111215 �� CornerRadius$ 5���  � ColumnDefinitions ��  � RowDefinitions �� $��30 ��� �� $��70 ��� $��70 ��� $��70 ��� $��50 ��� .+�� -   	 �Name$	 topbar�� �� �� $��30 ��� $��30 �.+��� $��0��$y�Hidden=�$��0��$	��API��$��14(�$��5 0 0 0q�
�������$��Center=�$
��Left=�A� -   
 A�Name$
 
api_status��$��0��$y�Hidden=�$��0�� � Cursor$
 Help��$
��Left=�$��35 5 0 5q� � ToolTip$M GNot connected. Please set the correct API url inside the settings file.��$��20�����	#FFAB1616
��������� -    ��Name$ minimizeBtn��$��1��
������ ���	#FFEAEAEA$��0q�$��0 0 0 3q�$��15(�$	��___��
������ �� -   $ closeBtn��$��2��
������ 
���  ��$��0q�$��0 0 0 5q�$��20(�$��X��
������ �� $��1��$��/Assets/Images/logo.png��$��Center=�$��Center=�$	��100���� $��2�����	#FF216BAE$��Center=�$��Center=�$	��300��$ 5��$��30��$��0 0 0 2q�._��� -    ��Name$ username_text��
������ 
������  �� 
CaretBrush
 ����� �� SelectionBrush
 ���� $��Username��
�������$
 Hand��$ Your username here.��$��Center=�$��Center=��� $��3�����	#FF216BAE$��Center=�$��Center=�$	��300��$ 5��$��30��$��0 0 0 2q�._�G� -    G�Name$ password_text��
������ 
������  G� 
CaretBrush
 ����� G� SelectionBrush
 ����  G� Password$ admin��
�������$
 Hand��$ Your username here.��$��Center=�$��Center=��� -	    ��Name$ passwordRepeat_border��$��4��$y�Hidden=����	#FF216BAE$��Center=�$��Center=�$	��300��$ 5��$��30��$��0 0 0 2q�._�G� -
   $ passwordRepeat_text��
������ 
������ 
 �����
 ���� $ admin��
�������$
 Hand��$ Your username here.��$��Center=�$��Center=��� -   $ msg_background��$��5��$y�Hidden=�
��� E��$��Center=�$��Center=�$ 5�� �� Padding$ 	10 0 10 0q�._��� -    ��Name$ msg_text��$��Your password is wrong.��
��������� -   $	 btn��$��6�����	#FF216BAE$ 5��$��Center=�$��Center=�$	��150��$��30��$ 	20 0 20 3q�$
 Hand��$��30��$��0 0 0 20q�._��� -    ��Name$ btn_text��$��Login��$��16(�$��0q� �� Padding$ 0q�
�������$��Center=�$��Center=��� -   $ btnText_text��$��6��$��Center=�$��Bottom=�
�������$
 Hand��$&�� No account yet? Create one here.��$��10 10 10 20q�