   M S B A M L   `   `   `  ����Q  MTemperaturueberwachung, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null?$clr-namespace:TemperaturueberwachungTemperaturueberwachung  5   	   M+clr-namespace:Page_Navigation_App.ViewModelPage_Navigation_App.ViewModel  5   	   M+clr-namespace:Page_Navigation_App.UtilitiesPage_Navigation_App.Utilities  5   	   '    !Temperaturueberwachung.MainWindow   5   	   W SPresentationCore, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35e aSystem.Windows.Controls.Ribbon, Version=7.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089R NWindowsBase, Version=7.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35F 9http://schemas.microsoft.com/winfx/2006/xaml/presentation     5   	   R NSystem.Xaml, Version=7.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   @d2http://schemas.microsoft.com/expression/blend/2008     5   	   Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5   	   6local$clr-namespace:Temperaturueberwachung     5   	   :vm+clr-namespace:Page_Navigation_App.ViewModel     5   	   <Menu+clr-namespace:Page_Navigation_App.Utilities     5   	   -   5          � Title$
  Home��5
   	   $	��600��5   	   $
��1000��5   	   
������  � WindowStyle$
 None=�5   	    � WindowStartupLocation$ CenterScreen=�5   	    � AllowsTransparency$
 True��5   	    � Icon$ Assets/Images/logo.ico��5   	   $��Dubai Medium)�5   	    � DataContext 5      0  *Page_Navigation_App.ViewModel.NavigationVM  5   
   .��5      � .+�5   
   �� -   5        ���	#FF111215 �� CornerRadius$ 5��5      5      � 5   
    � ColumnDefinitions 5       �� 5!      $	��220 �6#   �� 5"       � RowDefinitions 5%      �� 5&      $��30 �6    �� 5'      .+�5*      � -   5        	 �Name$	 topbar��5*      $��0��5+      $��0��5,      $��2��5-       5/      �� 50      $��60 �6'   �� 51      �� 52      $��30 �6'   �� 53      $��30 �6'   .+�56      �� $��0��6   $��0��57      $	��API��58      $��14(�59      $��5 0 0 0q�5:      
�������$��Center=�5<      $
��Left=�5=      A� 5?      -   5        
 A�Name$
 
api_status��5?      $��0��5@      $��0��5A       � Cursor$
 Help��5B      $
��Left=�5C      $��35 5 0 5q�5D       � ToolTip$@ :Not connected. Please set a valid api url in the settings.��5E      $��20��5F      ���	#FFAB1616
�������5H      �� 5J      -   5         ��Name$ current_version��5J      $��1��5K      $��0��5L      $��14(�5M      $��0q�5N      $��v.1.0.0��5O      $��Center=�5P      
�������$��5 0 0 0q�5R      �� 5T      -   5         ��Name$ info_background��5T      $��1��5U      $y�Visible=�5V      $��Center=�5W      $��Center=�5X      $��0 0 0 0q�5Y      $ 5��5Z       �� Padding$ 5 1 5 1q�5[      ���	#FFB7531A._�5_      �� -   5         ��Name$ 	info_text��5_       
�������$��14(�5a       $��Info can be here yeeee��5b       
������ 5c       5d      �� 5f      -   5         ��Name$ minimizeBtn��5f      $��2��5g      
������ ���	#FFEAEAEA$��0q�5j      $��0 0 0 3q�5k      $��15(�5l      $	��___��5m      
������ 5o      �� 5q      -	   5        $ closeBtn��5q      $��3��5r      
������ 
���  ��$��0q�5u      $��0 0 0 5q�5v      $��20(�5w      $��X��5x      
������ 5z      5|      � 5~      -
   5        $	 sidebar��5~      $��1��5      $��0��5�       5�      �� 5�      $	��23* �6'   �� 5�      $	��32* �6'   .+�5�      �� $
��Left=�6   $	��Top=�5�      $��2��5�      $��10,0,0,0q�5�      .+�5�      '   !Page_Navigation_App.Utilities.Btn     BtnStyle#��[  6    d� 	IsChecked$
 TrueY�5�      ��5�      �� *HomeCommand+.��5�      � .+�5�      �� $"��Assets/Images/Icons/home.png��6$     Image_Style#��[ 5�   $   �� 5�      $
��Home��6(     
Text_Style#��[ 5�   (   5�      5�        5�      #��[  6   ��5�      �� *SettingsCommand+.��5�      � .+�5�      �� $&�� Assets/Images/Icons/settings.png��6$   #��[ 5�   $   �� 5�      $��Settings��6(   #��[ 5�   (   5�      5�        5�      '   !Page_Navigation_App.Utilities.Btn   Click$ Logout_Click��5�      #��[  5�      .��5�      � .+�5�      �� $*��$/Assets/Images/Icons/shutdown_mo.png��6$   #��[ 5�   $   �� 5�      $��Logout��6(   #��[ 5�   (   5�      5�      5�      5�      � 5�      -   5        $	 
contenttab��5�      $��1��5�      $��1��5�      $��10q�5�      .+�5�      �� -   5         ��Name$ Pages��5�   !   ��5�   !   �� *CurrentView+5�      5�      5�      5�      