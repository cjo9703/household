package com.example.house_hold;

import android.support.v7.app.ActionBarActivity;
import android.content.Context;
import android.content.res.TypedArray;
import android.os.Bundle;
import android.util.AttributeSet;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.inputmethod.InputMethodManager;

class PieChart extends View{
	public boolean mShowText;
	public int mTextPos;
    
	public boolean isShowText(){
		return mShowText;
		
	}
	
	public void setShowText(boolean showText){
		mShowText = showText;
		invalidate();
		requestLayout();
	}
	public PieChart(Context context, AttributeSet attrs){
		super(context, attrs);
		TypedArray a = context.getTheme().obtainStyledAttributes(
				attrs,
				R.styleable.PieChart,
				0,0);
		try {
			mShowText = a.getBoolean(R.styleable.PieChart_showText,false);
		    mTextPos= a.getInteger(R.styleable.PieChart_labelPosition,0);
		}finally{
			a.recycle();
		}
	}
	
}
public class MainActivity extends ActionBarActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }
  
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
    
    public void showSoftKeyboard(View view){
    	if(view.requestFocus()){
    		InputMethodManager imm = (InputMethodManager)
    				getSystemService(Context.INPUT_METHOD_SERVICE);
    		imm.showSoftInput(view, InputMethodManager.SHOW_IMPLICIT);
    	}
    }
}

