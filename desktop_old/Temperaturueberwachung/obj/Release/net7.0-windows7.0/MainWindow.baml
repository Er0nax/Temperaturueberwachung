   M S B A M L   `   `   `  ���� Q  MTemperaturueberwachung, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null?$clr-namespace:TemperaturueberwachungTemperaturueberwachung  M+clr-namespace:Page_Navigation_App.ViewModelPage_Navigation_App.ViewModel  M+clr-namespace:Page_Navigation_App.UtilitiesPage_Navigation_App.Utilities  '    !Temperaturueberwachung.MainWindow   W SPresentationCore, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35e aSystem.Windows.Controls.Ribbon, Version=7.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089R NWindowsBase, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35F 9http://schemas.microsoft.com/winfx/2006/xaml/presentation     R NSystem.Xaml, Version=7.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     @d2http://schemas.microsoft.com/expression/blend/2008     Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     6local$clr-namespace:Temperaturueberwachung     :vm+clr-namespace:Page_Navigation_App.ViewModel     <Menu+clr-namespace:Page_Navigation_App.Utilities     -     � Title$
  Home��$	��600��$
��1000��
������  � WindowStyle$
 None=� � WindowStartupLocation$ CenterScreen=� � AllowsTransparency$
 True�� � Icon$ Assets/Images/logo.ico��$��Dubai Medium)� � DataContext 0  *Page_Navigation_App.ViewModel.NavigationVM  .��� .+��� -   ���	#FF111215 �� CornerRadius$ 5���  � ColumnDefinitions �� $	��220 ���  � RowDefinitions �� $��30 ��� .+�� -   	 �Name$	 topbar��$��0��$��0��$��2�� �� $��60 ��� �� $��30 ��� $��30 �.+��� $��0��$��0��$	��API��$��14(�$��5 0 0 0q�
�������$��Center=�$
��Left=�A� -   
 A�Name$
 
api_status��$��0��$��0�� � Cursor$
 Help��$
��Left=�$��35 5 0 5q� � ToolTip$@ :Not connected. Please set a valid api url in the settings.��$��20�����	#FFAB1616
��������� -    ��Name$ current_version��$��1��$��0��$��14(�$��0q�$��v.1.0.0��$��Center=�
�������$��5 0 0 0q��� -    ��Name$ info_background��$��1��$y�Visible=�$��Center=�$��Center=�$��0 0 0 0q�$ 5�� �� Padding$ 5 1 5 1q����	#FFB7531A._��� -    ��Name$ 	info_text��
�������$��14(�$��Info can be here yeeee��
������ �� -    ��Name$ minimizeBtn��$��2��
������ ���	#FFEAEAEA$��0q�$��0 0 0 3q�$��15(�$	��___��
������ �� -	   $ closeBtn��$��3��
������ 
���  ��$��0q�$��0 0 0 5q�$��20(�$��X��
������ � -
   $	 sidebar��$��1��$��0�� �� $	��23* ��� $	��32* �.+��� $
��Left=�$	��Top=�$��2��$��10,0,0,0q�.+�'   !Page_Navigation_App.Utilities.Btn     BtnStyle#��[   d� 	IsChecked$
 TrueY����� *HomeCommand+.��� .+��� $"��Assets/Images/Icons/home.png��  Image_Style#��[ �� $
��Home��  
Text_Style#��[   #��[  ���� *SettingsCommand+.��� .+��� $&�� Assets/Images/Icons/settings.png��#��[ �� $��Settings��#��[   '   !Page_Navigation_App.Utilities.Btn   Click$ Logout_Click��#��[  .��� .+��� $*��$/Assets/Images/Icons/shutdown_mo.png��#��[ �� $��Logout��#��[ � -   $	 
contenttab��$��1��$��1��$��10q�.+��� -    ��Name$ Pages������ *CurrentView+